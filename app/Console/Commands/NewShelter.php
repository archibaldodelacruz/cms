<?php

namespace App\Console\Commands;

use App\ProteCMS\Core\Models\Webs\Web;
use Illuminate\Console\Command;

class NewShelter extends Command
{
    protected $web;
    protected $description = 'Create a new shelter';
    protected $signature = 'protecms:newshelter 
                            {subdomain : Shelter\'s subdomain} 
                            {domain : Shelter\'s domain} 
                            {email : Shelter\'s email}';

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
        $web = $this->web;
        $web->domain = $this->argument('domain');
        $web->subdomain = $this->argument('subdomain');
        $web->email = $this->argument('email');
        $web->save();

        $code = mt_rand(00000, 99999);
        $web->setConfig('install_code', $code);

        $this->info('Shelter created successfully. The security code is: '.$code);
    }
}
