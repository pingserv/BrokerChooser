<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use Illuminate\Console\Command;

class StartChallenge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:start
    {challenge : Name of the challenge}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start challenge';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $challenge_name = $this->argument('challenge', false);

        $query = Challenge::where('name', $challenge_name);
        if (!$query->exists()) {
            $this->warn('Challenge doesn\'t exists!.');
            return false;
        }

        $challenge = $query->first();

        if ($challenge->status == 'stopped') {
            $this->warn('You can\'t start this challenge after stopped it.');
            return false;
        }

        $challenge->status = 'started';
        $challenge->save();

        $this->info('Challenge started.');
    }
}
