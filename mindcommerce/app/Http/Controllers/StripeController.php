<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Encryption\StringEncrypter;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Webhook;

use function Laravel\Prompts\info;

class StripeController extends Controller
{
    public static function createCheckout($cart_rows, $order_id)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $session = $stripe->checkout->sessions->create([

            'success_url' => env("APP_URL") . '/thank-you',
            "cancel_url" => env("APP_URL") . '/error',
            'line_items' => StripeController::generateLineItemsFromCart($cart_rows),
            'mode' => 'payment',
            //card, acss_debit, affirm, afterpay_clearpay, alipay, au_becs_debit, bacs_debit, bancontact, blik, boleto, cashapp, crypto, customer_balance, eps, fpx, giropay, grabpay, ideal, klarna, konbini, link, mb_way, multibanco, oxxo, p24, pay_by_bank, paynow, paypal, payto, pix, promptpay, sepa_debit, sofort, swish, upi, us_bank_account, wechat_pay, revolut_pay, mobilepay, zip, amazon_pay, alma, twint, kr_card, naver_pay, kakao_pay, payco, nz_bank_account, samsung_pay, billie, paypay, or satispay
            "payment_method_types" => ["card", "paypal", "klarna", "sepa_debit", "revolut_pay"],
            "payment_intent_data" => ["metadata" => ["order_id" => $order_id]]
        ]);



        return json_encode(["url" => $session->url]);
    }


    public static function generateLineItemsFromCart($cart_rows)
    {
        $formatted_line_items = [];
        foreach ($cart_rows as $row) {
            $formatted_line_items[] = [
                'price_data' =>
                [
                    "currency" => "eur",
                    "unit_amount" => round(($row["product"]["price"] * 1.22), 2) * 100,
                    "product_data" =>
                    [
                        "name" => $row["product"]["name"]
                    ]
                ],

                'quantity' => $row["qty"]
            ];
        }
        return $formatted_line_items;
    }


    public function handle_webhook(Request $request)
    {
        info($request->all());
        info($request->header("stripe-signature"));
        info(env('STRIPE_WEBHOOK_KEY'));
        // $event = Webhook::constructEvent($payload, $request->header("stripe-signature"), env('STRIPE_WEBHOOK_KEY'));

        // switch ($event->type) {
        //     case 'payment_intent.succeeded':
        //         $paymentIntent = $event->data->object; // questo è già un payment intent che è andato a buon fine

        //         $order = Order::find($paymentIntent->metadata);
        //         $order->status = "C";
        //         $order->save();
        //         break;
        //     case 'payment_intent.canceled':
        //         $paymentIntent = $event->data->object; // questo è già un payment intent che è stato cancellato
        //         break;
        //     case 'payment_intent.payment_failed':
        //         $paymentIntent = $event->data->object; // questo è già un payment intent che è fallito
        //         break;

        //     default:
        //         // Unexpected event type
        //         error_log('Received unknown event type');
        // }
    }
}
