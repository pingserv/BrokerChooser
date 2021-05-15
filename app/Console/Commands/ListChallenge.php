<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use Illuminate\Console\Command;

class ListChallenge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List challenges';

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
        $challenges = Challenge::with('variants')->get();
        $result = [];

        $challenges->each(function($item) use(&$result){
            array_push($result, [
                'challenge' => $item->name,
                'variants' => $item->variants->pluck('name')->implode(','),
                'status' => $item->status
            ]);
        });

        $this->table(['Challenge', 'Variants', 'Status'], $result);
    }
}
