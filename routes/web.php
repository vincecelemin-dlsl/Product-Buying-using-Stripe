<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/payment', function() {
    return view('payment');
});

Route::post('/checkout', function(Request $request) {
    // return $request;
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    try {
        $charge = \Stripe\Charge::create([
            'amount' => (5600*20),
            'currency' => 'PHP',
            'source' => $request->stripeToken,
            'description' => 'Test Description',
            'receipt_email' => 'vince_andrei_celemin@dlsl.edu.ph',
        ]);

        return redirect()->back()->with('message', 'Paid!');
    } catch (CardErrorException $e) {
        return $e->getMessage();
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/product', 'ProductsController');