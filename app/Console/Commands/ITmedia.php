<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models;

class ITmedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:itmedia';

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

        $crawler = $client->request('GET', 'https://www.itmedia.co.jp/');

        $crawler->filter('div.colBoxIndex')->each(function ($li) use ($client) {
            echo $li->filter('div.colBoxTitle h3 a')->text().PHP_EOL;
            echo $li->filter('div.colBoxTitle h3 a')->attr('href').PHP_EOL;


            $title = $li->filter('div.colBoxTitle h3 a')->text();
            $url = $li->filter('div.colBoxTitle h3 a')->attr('href');

            \App\ITmedia::insert([
                'title' => $title,
                'url' => $url
            ]);

            sleep(rand(2, 6));

    });

     
    }}