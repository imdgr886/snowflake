<?php

namespace Imdgr886\Snowflake;

use Illuminate\Console\Command as ConsoleCommand;

class Command extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snowflake:id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成 snowflake 唯一 ID';

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
        $this->info(app('snowflake')->next());
    }
}
