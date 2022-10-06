<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\User;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = Order::with(['items', 'items.product:id', 'coupons'])
        ->findOrFail($order->id);
        $this->user = User::where('role_id', 7)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.invoice');
    }
}
