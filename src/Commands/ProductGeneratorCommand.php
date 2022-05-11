<?php

namespace Sunilyadav\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ProductGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to generate csv file of product';

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
        // publish route
        $content = file_get_contents(base_path() . "/routes/web.php");
        if(strpos($content,"Route::get('/{platform}/get-products'") === false ){
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__ . '/../Resources/Routes/web.txt'),
                FILE_APPEND
            );
        }

        // publish controller
        (new Filesystem)->copyDirectory(__DIR__ . '/../Resources/Controllers', app_path('Http/Controllers/'));
    }
}
