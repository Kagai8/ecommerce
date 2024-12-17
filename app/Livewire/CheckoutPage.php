<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use App\PaystackService;
use Yabacon\Paystack;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Flutterwave\Flutterwave; // Use Flutterwave's v3 SDK
use Illuminate\Support\Facades\Mail;
use Log;

#[Title('Checkout Page-Tech Soko Kenya')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function mount()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();

        if (count($cart_items) == 0) {
            return redirect('/products');
        }
    }

    public function placeOrder()
    {
        // Validate the input fields
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        // Get cart items and calculate totals
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        // Create the order
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = $grand_total;
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'kes';
        $order->notes = 'Order placed by ' . auth()->user()->name;
        $order->save();

        // Save the shipping address
        $address = new Address();
        $address->order_id = $order->id;
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->save();

        // Add items to the order
        $order->items()->createMany($cart_items);

        // Handle payment with Flutterwave
        if ($this->payment_method === 'card') {
            try {
                $paystackService = new PaystackService();

                $paymentData = $paystackService->initializePayment(
                    auth()->user()->email,
                    $grand_total,
                    route('payment.callback', ['order_id' => $order->id])
                );

                if (isset($paymentData['data']['authorization_url'])) {
                    return redirect($paymentData['data']['authorization_url']); // Redirect to Paystack's payment page
                } else {
                    session()->flash('error', 'Payment initialization failed.');
                }
            } catch (\Exception $e) {
                session()->flash('error', 'An error occurred: ' . $e->getMessage());
            }
            
        } else {
            // Handle Cash on Delivery logic
            CartManagement::clearCartItems();
            Mail::to(request()->user())->send(new OrderPlaced($order));
            return redirect(route('success'));
        }
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
