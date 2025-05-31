<?php

namespace App\Http\Controllers;

use App\Models\ProductUser;
use App\Models\Product;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function winners()
    {
        $products = Product::where('status', 1)->where('expired_at', '<', now())->take(20)->get();

        foreach($products as $product)
        {
            $heightRequest = ProductUser::where('product_id', $product->id)->orderBy('price', 'desc')->first();
            $winner = User::findOrFail($heightRequest->user_id);
            $productUsers = ProductUser::whereNot('id', $heightRequest->id)->where('product_id', $product->id)->where('product_creator_id', $product->user_id)->get();

            if($product->user_id != 0)
            {
                $owner = User::findOrFail($product->user_id);
                $owner->balance += $heightRequest->price;
                $owner->save();


                notify($owner, 'AUCTION_ENDED_OWNER_NOTIFICATION', [
                    'auction_owner' => $owner->fullname,
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightRequest->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($productUsers->count() + 1),
                    'link' => getProductUrl($product)
                ]);

            }

            if($winner)
            {
                notify($winner, 'AUCTION_WINNER_NOTIFICATION', [
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightRequest->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($productUsers->count() + 1),
                    'link' => getProductUrl($product)
                ]);
            }

            foreach($productUsers as $productUser)
            {
                $participant = User::findOrFail($productUser->user_id);

                $participant->balance += $productUser->price;
                $participant->save();


                notify($participant, 'NON_WINNER_AUCTION_NOTIFICATION', [
                    'participant_name' => $participant->fullname,
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightRequest->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($productUsers->count() + 1),
                    'link' => getProductUrl($product)
                ]);
            }

            $winnerData = new Winner();
            $winnerData->user_id = $winner->id;
            $winnerData->product_id = $product->id;
            $winnerData->product_owner_id = $product->user_id;
            $winnerData->bid_id = $heightRequest->id;
            $winnerData->status = 0;
            $winnerData->save();


            $product->status = 2;
            $product->save();


        }


    }


}
