<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models;

class newsweekjapan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:newsweekjapan';

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
        
        for ( $num = 1 ; $num < 10 ; $num++) {
            $i = "index.php";
            if ($num > 1) {  //１以上の時下記を実行する
              $i  = "index_".$num.".php";
            }
        
        

            $crawler = $client->request('GET', 'https://www.newsweekjapan.jp/stories/'.$i);

            $crawler->filter('div.top div.entry.clearfix.border_btm.containImg')->each(function ($li) use ($client) {
                if ($li->filter('a div h3')->count() > 0){
                echo $li->filter('a div h3')->text().PHP_EOL;
                echo $li->filter('a')->attr('href').PHP_EOL;
                echo $li->filter('a div div.date')->text('field list').PHP_EOL;
                echo $li->filter('a div img')->attr('src').PHP_EOL;

                $title = $li->filter('a div h3')->text();
                $url = $li->filter('a')->attr('href');
                $datetime = $li->filter('a div div.date')->text('field list');
                $img = $li->filter('a div img')->attr('src');


                \App\newsweekjapan::insert([
                    'title' => $title,
                    'url' => $url,
                    'field list' => $datetime,
                    'img' => $img
                ]);
                }

                sleep(rand(1,5));

            });

            
        }
    }
    }
