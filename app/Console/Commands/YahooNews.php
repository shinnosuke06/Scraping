<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models;

class YahooNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:yahoonews';

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



        // Goutteを使えるようにする
        $client = new \Goutte\Client();

    // MacのChromeでアクセスしたかのように偽装する
    $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3864.0 Safari/537.36');

    // Yahoo!のトップページのHTMLを取得する
    for ($i = 1 ; $i <= 10 ; $i++) {
        $crawler = $client->request('GET', 'https://news.yahoo.co.jp/topics/top-picks?page='.$i);

        // Yahoo!のHTMLから指定したパスの情報を取得し、件数分ループ処理を行う ( 下記画像の赤枠部分を指定 )
        $crawler->filter('html body div main div div div div ul li')->each(function ($li) {

            // Yahoo!トップページの「ニュース」タブのニュースタイトルを取得し表示する ( 下記画像のオレンジ枠部分を指定 )
            if ($li->filter('a div div.newsFeed_item_title')->count() > 0){
            echo $li->filter('a div div.newsFeed_item_title')->text().PHP_EOL;
            echo $li->filter('a.newsFeed_item_link')->attr('href').PHP_EOL;
            echo $li->filter('a div div div time.newsFeed_item_date')->text('field list').PHP_EOL;
            echo $li->filter('a div div img')->attr('src').PHP_EOL;


            $title = $li->filter('a div div.newsFeed_item_title')->text();
            $url = $li->filter('a.newsFeed_item_link')->attr('href');
            $date_time = $li->filter('a div div div time.newsFeed_item_date')->text('field list');
            $img = $li->filter('a div div img')->attr('src');


        // $crawler2 = $client->request('GET', 'https://news.yahoo.co.jp/topics/top-picks'.$li->filter('')->attr('href'));
        // echo $crawler2->filter('')->time().PHP_EOL;
        // $time = $crawler2->filter('')->time();

            \App\YahooNews::insert([
                'title' => $title,
                'url' => $url,
                'fieldlist' => $date_time,
                'img' => $img
            ]);

            sleep(rand(1, 5));
            }
        });

        
    
    };
/*
        // Goutteを使えるようにする
        $client = new \Goutte\Client();

    // MacのChromeでアクセスしたかのように偽装する
    $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3864.0 Safari/537.36');

    // Yahoo!のトップページのHTMLを取得する
    for ($i = 1 ; $i <= 10 ; $i++) {

        $crawler = $client->request('GET', 'https://qiita.com/search?q=PHP&page='.$i);

        // Yahoo!のHTMLから指定したパスの情報を取得し、件数分ループ処理を行う ( 下記画像の赤枠部分を指定 )
        $crawler->filter('div.searchResult_main')->each(function ($li) use ($client) {

            // Yahoo!トップページの「ニュース」タブのニュースタイトルを取得し表示する ( 下記画像のオレンジ枠部分を指定 )
            echo $li->filter('h1 a')->text().PHP_EOL;
            echo $li->filter('h1 a')->attr('href').PHP_EOL;

            $title = $li->filter('h1 a')->text();
            $url = $li->filter('h1 a')->attr('href');

            $crawler2 = $client->request('GET', 'https://qiita.com'.$li->filter('h1 a')->attr('href'));
            echo $crawler2->filter('.ai-User_urlname')->text().PHP_EOL;
            $author = $crawler2->filter('.ai-User_urlname')->text();

            // データベース
            Qiita::insert([
                'title' => $title,
                'url' => $url,
                'author' => $author
            ]);

            sleep(rand(1, 5));

        });
*/

    }

}