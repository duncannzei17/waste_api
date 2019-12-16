<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Schedule;
use DB;

class DigiwasteScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:garbage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check schedules table to update active shedule records';

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
     * @return mixed
     */
    public function handle()
    {

    }
}
