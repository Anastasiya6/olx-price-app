<?php

namespace App\Services;

use App\Jobs\RecordInitialPrice;
use App\Models\Link;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SaveSubscriptionService
{
    public function store(Request $request)
    {
        $existingLink = Link::where('link', $request->olxLink)->first();

        if ($existingLink) {

            $linkId = $existingLink->id;

        } else {

            $newLink = Link::create(['link' => $request->olxLink]);

            $linkId = $newLink->id;

            RecordInitialPrice::dispatch($linkId,$request->olxLink);

        }
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => 'subscription',
                'password' => bcrypt('1111'),
            ]
        );

        Subscription::firstOrCreate([
            'user_id' => $user->id,
            'link_id' => $linkId,
        ]);
    }
}
