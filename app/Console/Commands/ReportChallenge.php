<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use App\Models\Event;
use Illuminate\Console\Command;

class ReportChallenge extends Command
{
    protected $signature = 'challenge:report
    {challenge : Name of the challenge}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report challenge';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $challenge_name = $this->argument('challenge', false);

        $query = Challenge::where('name', $challenge_name);
        if (!$query->exists())
        {
            $this->error('Challenge doesn\'t exists!.');
            return false;
        }

        $report = [];

        $hits = Event::select(\DB::raw('label as variant, count(*) as hits'))
            ->where('action', 'hit')
            ->groupBy('variant')->get();

        foreach ($hits as $hit) {
            $report[$hit->variant] = [
                'challenge' => $challenge_name,
                'variant' => $hit->variant,
                'hits' => $hit->hits,
                'goals' => 0,
                'conversion' => 0,
            ];
        }

        $goals = Event::select(\DB::raw('label as variant, count(*) as goals'))
            ->where('action', 'goal')
            ->groupBy('label')->get();

        foreach ($goals as $goal) {
            $report[$goal->variant]['goals'] = $goal->goals;
            $report[$goal->variant]['conversion'] = ($goal->goals / $report[$goal->variant]['hits']) * 100;
        }

        usort($report, function ($a, $b) {
            return $a['conversion'] < $b['conversion'];
        });

        $this->table(['Challange', 'Variant', 'Hit', 'Goals', 'Conversion'], $report);

    }
}
