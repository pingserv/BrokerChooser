<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use Illuminate\Console\Command;

class StopChallenge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:stop
    {challenge : Name of the challenge}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop challenge';

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
        if (!$query->exists())
        {
            $this->error('Challenge doesn\'t exists!.');
            return false;
        }

        $challenge = $query->first();
        $challenge->status = 'stopped';
        $challenge->save();

        $this->warn('Challenge stopped.');
    }
}
