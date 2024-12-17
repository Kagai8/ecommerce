<?php

use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\CategoriesPage;
use App\Livewire\ProductsPage;
use App\Livewire\CartPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ForgetPasswordPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\SuccessPage;
use App\Livewire\CancelPage;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class);

Route::middleware('guest')->group(function () {
	Route::get('/login', LoginPage::class)->name('login');
	Route::get('/register', RegisterPage::class);
	Route::get('/forgot', ForgetPasswordPage::class)->name('password.request');
	Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');;
});


Route::middleware('auth')->group(function () {
	Route::get('/logout', function (){
		auth()->logout();
		return redirect('/');
	});
	Route::get('/checkout', CheckoutPage::class);
	Route::get('/my-orders', MyOrdersPage::class);
	Route::get('/my-orders/{order}', MyOrderDetailPage::class)->name('my-orders.show');
	Route::get('/success', SuccessPage::class)->name('success');
	Route::get('/cancel', CancelPage::class);





    Route::get('/payment/callback', function (Request $request) {
        try {
            $paystackService = new PaystackService();
            $paymentDetails = $paystackService->verifyPayment($request->get('reference'));

            if ($paymentDetails['data']['status'] === 'success') {
                $order = Order::findOrFail($request->get('order_id'));
                $order->payment_status = 'completed';
                $order->save();

                CartManagement::clearCartItems();
                Mail::to(request()->user())->send(new OrderPlaced($order));

                return redirect('/success')->with('message', 'Payment Successful!');
            } else {
                return redirect('/checkout')->with('error', 'Payment verification failed.');
            }
        } catch (\Exception $e) {
            return redirect('/checkout')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    })->name('payment.callback');


});
