<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Cart;
use App\Product;
use App\CartItem;
use App\Category;
use App\Billing;
use App\Shipping;
use App\Order;
use App\OrderItem;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // cart insert was put on AuthenticateUsers@sendloginresponces
        // cart insert was put on RegistersUsers@register
        $categories = Category::get();
        $products = Product::get();
        $cart_items = CartItem::join('products', 'cart_items.product_id', '=', 'products.id')
            ->get();
        return view('home', compact('categories', 'products', 'cart_items'));
    }

    public function getProduct(Request $request){
        $categoryId = $request->id;

        $dairyProducts = Product::where('category_id', $categoryId)->get();
        if ($request->isMethod('get')){    
            return response()->json($dairyProducts); 
        }
    }

    public function addToCart(Request $request, $id){
        $user_id = Auth::user()->id;
        $cart_id = Cart::where('user_id', $user_id)->where('is_checkout', 0)->where('is_cancelled', 0)->where('is_abandoned', 0)->value('id');
        $quantity = 1;
        $price = Product::where('id',$id)->value('price');
        
        $existing = CartItem::where('product_id',$id)->get();

        if ($existing == "[]"){
            DB::table('cart_items')->insert([
                'cart_id' => $cart_id,
                'product_id' => $id,
                'amount' => $price,
                'quantity' => $quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            Product::where('id',$id)->decrement('stock');
        }
        if ($existing != "[]"){
            CartItem::where('product_id',$id)->increment('quantity');
            Product::where('id',$id)->decrement('stock');
            $quantity = CartItem::where('product_id',$id)->value('quantity');
            $amount = $quantity * $price;
            CartItem::where('product_id',$id)->update(['amount' => $amount]);
        }
        
        return redirect('/home');

    }

    public function deleteProduct(Request $request, $cart_id, $product_id, $quantity){
        CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->delete();
        Product::where('id',$product_id)->increment('stock', $quantity);
        return redirect('/home');
    }

    public function checkout(Request $request)
    {
        return view('shipping');
    }

    public function placeOrders(Request $request)
    {
        $name_billings = $request->name_billings;
        $card_no = $request->card_no;
        $card_type = $request->card_type;
        $exp_date = $request->exp_date;
        $security_code = $request->security_code;

        $name_shippings = $request->name_shippings;
        $address = $request->address;
        $city = $request->city;
        $country = $request->country;
        $contact_no = $request->contact_no;
        $email = $request->email;

        $billing = new Billing;
        $billing->name = $name_billings;
        $billing->card_no = $card_no;
        $billing->card_type = $card_type;
        $billing->exp_date = $exp_date;
        $billing->security_code = $security_code;
        $billing->save();

        $shipping = new Shipping;
        $shipping->name = $name_shippings;
        $shipping->address = $address;
        $shipping->city = $city;
        $shipping->country = $country;
        $shipping->contact_no = $contact_no;
        $shipping->email = $email;
        $shipping->save();

        $user_id = Auth::user()->id;
        $billing_id = Billing::where('name', $name_billings)->where('card_no', $card_no)->where('card_type', $card_type)->where('exp_date', $exp_date)->where('security_code', $security_code)->value('id');
        $shipping_id = Shipping::where('name', $name_shippings)->where('address', $address)->where('city', $city)->where('country', $country)->where('contact_no', $contact_no)->where('email', $email)->value('id');
        $cart_id = Cart::where('user_id', $user_id)->where('is_checkout', 0)->where('is_cancelled', 0)->where('is_abandoned', 0)->value('id');
        $total_amount = CartItem::where('cart_id', $cart_id)->sum('amount');
        $total_items = CartItem::where('cart_id', $cart_id)->sum('quantity');

        $order = new Order;
        $order->user_id = $user_id;
        $order->billing_id = $billing_id;
        $order->shipping_id = $shipping_id;
        $order->cart_id = $cart_id;
        $order->total_amount = $total_amount;
        $order->total_items = $total_items;
        $order->save();

        $order_id = Order::where('user_id', $user_id)->where('billing_id', $billing_id)->where('shipping_id', $shipping_id)->where('cart_id', $cart_id)->where('total_amount', $total_amount)->where('total_items', $total_items)->value('id');

        $cart_items = CartItem::where('cart_id', $cart_id)->get();
        foreach ($cart_items as $cart_item) {
            $order_items = new OrderItem;
            $order_items->order_id = $order_id;
            $order_items->cart_id = $cart_item->cart_id;
            $order_items->product_id = $cart_item->product_id;

            $price = Product::where('id', $cart_item->product_id)->value('price');
            $name = Product::where('id', $cart_item->product_id)->value('name');

            $order_items->price = $price;
            $order_items->name = $name;
            $order_items->amount = $cart_item->amount;
            $order_items->quantity = $cart_item->quantity;
            $order_items->save();
        }

        return redirect('/order/'.$order_id.'/'.$cart_id);
    }

    public function order(Request $request, $order_id, $cart_id)
    {
        // echo $order_id;
        // echo $cart_id;
        $user_id = Auth::id();
        $order_items = OrderItem::where('order_id', $order_id)->where('cart_id', $cart_id)->get();
        $total_amount = Order::where('user_id', $user_id)->where('cart_id', $cart_id)->value('total_amount');
        $total_items = Order::where('user_id', $user_id)->where('cart_id', $cart_id)->value('total_items');
        return view('order', compact('order_items', 'total_amount', 'total_items'));
    }

    public function thankyou(Request $request)
    {
        $user_id = Auth::id();
        $cart_id = Cart::where('user_id', $user_id)->where('is_checkout', 0)->where('is_cancelled', 0)->where('is_abandoned', 0)->value('id');
        // echo $cart;
        CartItem::where('cart_id', $cart_id)->delete();
        Cart::where('user_id', $user_id)->where('is_checkout', 0)->where('is_cancelled', 0)->where('is_abandoned', 0)->update(['is_checkout' => 1]);
        return view('thankyou');
    }

    public function createUser()
    {
        $carts = new Cart;
        $carts->user_id = Auth::user()->id;
        $carts->is_checkout = 0;
        $carts->is_cancelled = 0;
        $carts->is_abandoned = 0;
        $carts->save();

        return redirect('/home');
    }
}
