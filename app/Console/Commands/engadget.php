<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models;

class engadget extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:engadget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $client = new \Goutte\Client();

        $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3864.0 Safari/537.36');

        $crawler = $client->request('GET', 'https://japanese.engadget.com/');

        $crawler->filter('div.rwd-inner-container div div ul li article')->each(function ($li) use ($client) {
            //echo $li->filter('div div div div h2 a')->text().PHP_EOL;
            echo $li->filter('div a')->attr('href').PHP_EOL;
            
            //$title = $li->filter('div div div div h2 a')->text();
            $url = $li->filter('div a')->attr('href');

        $crawler2 = $client->request('GET', 'https://japanese.engadget.com/'.$li->filter('div a')->attr('href'));
            echo $crawler2->filter('div#module-engadget-deeplink-post.wafer-rapid-module div div div div div div h1')->text().PHP_EOL;
            echo $crawler2->filter('div#post-center-col div div img')->attr('src').PHP_EOL;

            $title = $crawler2->filter('div#module-engadget-deeplink-post.wafer-rapid-module div div div div div div h1')->text();
            $img = $crawler2->filter('div#post-center-col div div img')->attr('src');


            \App\engadget::insert([
                'title' => $title,
                'url' => $url,
                'img' => $img
            ]);

            sleep(rand(1, 5));

    });

     
    }
    }

