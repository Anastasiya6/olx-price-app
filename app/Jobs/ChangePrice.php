<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\ProductPrice;
use App\Models\User;
use App\Notifications\PriceChangedNotification;
use App\Services\OlxParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ChangePrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OlxParserService $olxParserService)
    {
        Log::info('change price '.now());

        $links = Link::all();

        foreach($links as $link){
            Log::info('link '.$link->id.' '.$link->link);

            $price_now = $olxParserService->olxParser($link->link);
            Log::info('price now '.$price_now);
            if($price_now){

                $old_price = ProductPrice::where('link_id', $link->id)->orderBy('created_at','desc')->first();
                Log::info('price old '.$old_price);

                if(!$old_price || (isset($old_price->price) && $old_price->price != $price_now)){

                        ProductPrice::create([
                            'link_id' => $link->id,
                            'price' => $price_now,
                        ]);
                    $subscribedUsers = User::whereHas('subscriptions', function ($query) use ($link) {
                        $query->where('link_id', $link->id);
                    })->get();

                    Notification::send($subscribedUsers, new PriceChangedNotification($price_now, $link->link));

                }
            }
        }


    }
}
