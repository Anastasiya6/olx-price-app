<?php

namespace App\Jobs;

use App\Models\ProductPrice;
use App\Services\OlxParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\BrowserKit\HttpBrowser;

class RecordInitialPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $link;

    protected $linkId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($linkId, $link)
    {
        $this->link = $link;

        $this->linkId = $linkId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OlxParserService $olxParserService)
    {
        $price = $olxParserService->olxParser($this->link);
        Log::info('ціну знайдено '.$price);
        if($price) {
            ProductPrice::create([
                'link_id' => $this->linkId,
                'price' => $price,
            ]);
        }
    }
}
