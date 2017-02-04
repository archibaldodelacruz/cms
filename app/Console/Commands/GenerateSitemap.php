<?php

namespace App\Console\Commands;

use Log;
use Exception;
use App\Models\Webs\Web;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'protecms:generatesitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemaps for all webs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Web $web)
    {
        parent::__construct();

        $this->web = $web;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->web->all() as $web) {
            try {
                SitemapGenerator::create($web->getUrl())
                    ->writeToFile($web->getStorageFolder('sitemap.xml'));
            } catch (Exception $e) {
                Log::error('Error generating a sitemap for '.$web->name);
            }
        }
    }
}
