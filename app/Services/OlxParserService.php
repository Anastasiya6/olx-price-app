<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class OlxParserService
{
    public function olxParser($link )
    {
        $client = new Client();

        $response = $client->request('GET', $link);

        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $priceElement = $crawler->filter('h3.css-12vqlj3')->first();

        if ($priceElement->count() > 0) {

            $priceText = $priceElement->text();

            $numericPrice = filter_var($priceText, FILTER_SANITIZE_NUMBER_INT);

            if ($numericPrice !== false) {

                return $numericPrice;

            } else {
                Log::info( "Цифри не знайдено для ".$this->link);
            }
        } else {
            Log::info("Ціна не знайдена для ".$this->link);
        }

        return null;
    }
}
