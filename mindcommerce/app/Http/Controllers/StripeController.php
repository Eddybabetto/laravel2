<?php

namespace App\Http\Controllers;

use App\Mail\SendTestMail;
use App\Models\Order;
use Illuminate\Contracts\Encryption\StringEncrypter;
use Illuminate\Http\Request;
use Illuminate\Log\Logger as LogLogger;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
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


    public function handle_webhook()
    {
     
        //la documentazione ce lo spiega cosi, laravel fa i capricci e quindi lo teniamo cosi
        $payload = @file_get_contents("php://input");

        $event = Webhook::constructEvent($payload, $_SERVER["HTTP_STRIPE_SIGNATURE"], env('STRIPE_WEBHOOK_KEY'));
      
        info($event);
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // questo è già un payment intent che è andato a buon fine
                info($paymentIntent);
                $order = Order::find($paymentIntent->metadata["order_id"]);
                info($order);
                $order->status = "C";
                $order->save();
                break;
            case 'payment_intent.canceled':
                $paymentIntent = $event->data->object; // questo è già un payment intent che è andato a buon fine
                info($paymentIntent);
                $order = Order::find($paymentIntent->metadata["order_id"]);
                info($order);
                $order->status = "R";
                $order->save();
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object; // questo è già un payment intent che è andato a buon fine
                info($paymentIntent);
                $order = Order::find($paymentIntent->metadata["order_id"]);
                info($order);
                $order->status = "R";
                $order->save();
                break;

            default:
                // Unexpected event type
                error_log('Received unknown event type');
        }
    }

public function SendMail($to, $subject, $body) : bool {
     
//invio base di email con testo semplice
 Mail::send([], [], function ($message) {
        $message->to("test@test.com", "Test User")
                ->subject("Test Email")
                ->text("This is a test email from Laravel 12.");
        });


        //invio di email usando un blade (frontend php) più complesso

    $data = [
        'name' => 'Test User',
        'body' => 'This is a test email from Laravel 12.'
    ];

    Mail::send('emails.test_email', $data, function ($message) {
        $message->to("test@test.com", "Test User")
                ->subject("Test Email");
    });


    //invio mail usando un mailable: 
    //oggetto complesso e moderno di laravel per formattare e rendere dinamiche le mail
    // deve essere creato prima il file con il comando "php artisan make:mail SendTestMail"
    Mail::to('test@test.com')->send(new SendTestMail("name", "message"));
        return true;
}
}
