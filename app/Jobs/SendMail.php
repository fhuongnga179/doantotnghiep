<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $phone;
    protected $address;
    protected $content;
    protected $payment_image;
    protected $productsInCart;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $phone, $address, $content, $payment_image, $productsInCart)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->content = $content;
        $this->payment_image = $payment_image;
        $this->productsInCart = $productsInCart->toArray();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new OrderShipped([
            'customerName' => $this->name,
            'customerPhone' => $this->phone,
            'customerAddress' => $this->address,
            'customerEmail' => $this->email,
            'customerContent' => $this->content,
            'products' => $this->productsInCart,
            'totalAmount' => 0, // You can calculate the total amount if needed
        ]));
    }
}
