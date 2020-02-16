<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models;

class techcrunch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:techcrunch';

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
            
            for ($i = 1 ; $i <= 10 ; $i++) {
            $crawler = $client->request('GET', 'https://jp.techcrunch.com/page/'.$i);

            $crawler->filter('div div div div div ul li.river-block')->each(function ($li) use ($client) {
                if($li->filter('div div h2.post-title a')->count() > 0){
                echo $li->filter('div div h2.post-title a')->text().PHP_EOL;
                echo $li->filter('div div h2.post-title a')->attr('href').PHP_EOL;

                $title = $li->filter('div div h2.post-title a')->text();
                $url = $li->filter('div div h2.post-title a')->attr('href');

                \App\techcrunch::insert([
                    'title' => $title,
                    'url' => $url
                ]);
                }

                sleep(rand(2, 6));
            
    });
    }
}
}