<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Order;

use Stripe;

use Session;

use Illuminate\Support\Facades\Auth;

use function Flasher\Toastr\Prime\toastr;



class HomeController extends Controller
{
    public function index()
    {
        // Ensure only admin users can access this view. If not admin, redirect to normal dashboard.
        //
        // Problem: a previous edit accidentally declared the `home()` method inside this
        // `index()` method (a nested function). That produced a PHP syntax error at runtime
        // and flagged an error at this file/line. Nested method definitions are invalid in PHP.
        //
        // Solution: return the admin view here and define `home()` as a separate method
        // at the class level (below). Use the `auth()` helper to check authentication and
        // the `usertype` attribute to authorize access.
        if (! auth()->check() || auth()->user()->usertype !== 'admin') {
            return redirect()->route('dashboard');
        }

        $user = User::where('usertype', 'user')->get()->count();

        $product = Product::all()->count();

        $order = Order::all()->count();

        $deliverd = Order::where('status', 'Delivered')->get()->count();

        return view('admin.index', compact('user', 'product', 'order', 'deliverd'));
    }

    /**
     * Public home for normal users.*/



    public function home()
    {
        $product = Product::all();

        if (Auth::id()) {
            $user = Auth::user();

            $userid = Auth::id();

            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.index', compact('product', 'count'));
    }

    public function login_home()
    {
        $product = Product::all();

        if (Auth::id()) {
            $userid = Auth::id();
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.index', compact('product', 'count'));
    }

    public function product_details($id)
    {
        $data = Product::find($id);

        $product = Product::all();

        if (Auth::id()) {
            $userid = Auth::id();
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.product_details', compact('data', 'count'));
    }

    public function add_cart($id)
    {

        // $product=Product::find($id);
        $product_id = $id;
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        $user_id = Auth::id();

        $data = new Cart;
        $data->user_id = $user_id;

        $data->product_id = $product_id;

        $data->save();

        toastr()->timeout(10000)->closeButton()->addSuccess('Product added to cart successfully!');

        return redirect()->back();
    }

    public function mycart()
    {
        // Require authentication to view the cart
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userid = Auth::id();
        $count = Cart::where('user_id', $userid)->count();
        $cart = Cart::where('user_id', $userid)->get();

        return view('home.mycart', compact('count', 'cart'));
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);

        if (! $cart) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        $cart->delete();

        toastr()->timeout(10000)->closeButton()->addSuccess('Product removed from cart successfully!');

        return redirect()->back();
    }

    public function confirm_order(Request $request)
    {

        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;

        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userid = Auth::id();

        $cart = Cart::where('user_id', $userid)->get();

        foreach ($cart as $carts) {
            $order = new Order;

            $order->product_id = $carts->product_id;

            $order->name = $name;
            $order->red_address = $address;
            $order->phone = $phone;

            $order->user_id = $userid;
            $order->payment_status ='cash on delivery';
            $order->save();
        }


        $cart_remove = Cart::where('user_id', $userid)->get();

        foreach ($cart_remove as $remove) {
            $data = Cart::find($remove->id);

            $data->delete();
        }

        toastr()->timeout(10000)->closeButton()->addSuccess('Product ordered from cart successfully!');

        return redirect()->back();
    }

    public function myorders()
    {

        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userid = Auth::id();

        $order = Order::where('user_id', $userid)->get();

        $count = Cart::where('user_id', $userid)->count();
        return view('home.order', compact('count', 'order'));
    }

    public function stripe($value)
    {

        return view ('home.stripe',compact('value'));
    }

    public function stripePost(Request $request,$value)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create charge once with the token
            Stripe\Charge::create ([
                "amount" => $value * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from Complete" 
            ]);

            $userid = Auth::id();
            $name = Auth::user()->name;
            $phone = Auth::user()->phone;
            $address = Auth::user()->address;

            $cart = Cart::where('user_id', $userid)->get();

            // Create orders for each cart item
            foreach ($cart as $carts) {
                $order = new Order;
                $order->product_id = $carts->product_id;
                $order->name = $name;
                $order->red_address = $address;
                $order->phone = $phone;
                $order->user_id = $userid;
                $order->payment_status = 'Paid';
                $order->save();
            }

            // Remove cart items
            $cart_remove = Cart::where('user_id', $userid)->get();
            foreach ($cart_remove as $remove) {
                $data = Cart::find($remove->id);
                $data->delete();
            }

            toastr()->timeout(10000)->closeButton()->addSuccess('Product ordered from cart successfully!');
            return redirect()->back();

        } catch(\Exception $e) {
            toastr()->timeout(10000)->closeButton()->addError('Payment failed: ' . $e->getMessage());
            return redirect('mycart');
        }
    }

     public function shop()
    {
        $product = Product::all();

        if (Auth::id()) {
            $user = Auth::user();

            $userid = Auth::id();

            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.shop', compact('product', 'count'));
    }

    public function why()
    {
        

        if (Auth::id()) {
            $user = Auth::user();

            $userid = Auth::id();

            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.why', compact( 'count'));
    }

      public function testimonial()
    {
        

        if (Auth::id()) {
            $user = Auth::user();

            $userid = Auth::id();

            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.testimonial', compact( 'count'));
    }

      public function contact()
    {
        

        if (Auth::id()) {
            $user = Auth::user();

            $userid = Auth::id();

            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.contact', compact( 'count'));
    }
}
