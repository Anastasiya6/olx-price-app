<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\BrowserKit\HttpBrowser;

class OlxParserService
{
    public function olxParser($link )
    {
        $client = new HttpBrowser();

        $crawler = $client->request('GET', $link);

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
