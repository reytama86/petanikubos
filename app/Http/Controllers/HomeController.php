<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\About;
use App\Models\transaksi_total;
use App\Models\Produk;
use App\Models\Slider;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Testimoni;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    
    public function index()
    {
        $sliders = Slider::all();
        $categories = Produk::all();
        $products = Produk::skip(0)->take(8)->get();
        return view('home.index', compact('sliders', 'categories', 'products'));
    }

    public function products($id_category)
    {
        $products = Produk::where('id_kategori', $id_category)->get();
        return view('home.products', compact('products'));
    }

    public function searchProducts(Request $request)
    {
    $searchTerm = $request->input('search');
    $products = Produk::where('nama_produk', 'like', "%$searchTerm%")->get();

    return response()->json(['products' => $products]);

    }


    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Keranjang::create($input);
    }

    public function delete_from_cart(Keranjang $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }

    public function product($id_produk)
    {
        $product = Produk::find($id_produk);
        $latest_products = Produk::orderByDesc('created_at')->offset(0)->limit(10)->get();
        return view('home.product', compact('product', 'latest_products'));
    }

    // public function product_search(Request $request)
    // {
    //     // Gunakan $products sesuai kebutuhan dalam pencarian
    //     $productName = $request->input('name');
    //     $searchedProducts = Product::where('name', 'like', "%$productName%")->get();

    //     return response()->json(['products' => $searchedProducts]);
    // }
    // public function showSearchForm()
    // {
    //     return view('home.search'); // Sesuaikan dengan nama file view Anda
    // }
    public function cart()
    {
        if (!Auth::guard('webmember')->user()) {
            return redirect('/login_member');
        }
        $carts = Keranjang::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Keranjang::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->sum('total');
        return view('home.cart', compact('carts','cart_total'));
    }

    // public function get_kota($id)
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => array(
    //             "key: 1adb8efa384245ff3bc71d4d2429518a"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     } else {
    //         echo $response;
    //     }
    // }

    // public function get_ongkir($destination, $weight)
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => "origin=369&destination=" . $destination . "&weight=" . $weight . "&courier=jne",
    //         CURLOPT_HTTPHEADER => array(
    //             "content-type: application/x-www-form-urlencoded",
    //             "key: 1adb8efa384245ff3bc71d4d2429518a"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     } else {
    //         echo $response;
    //     }
    // }

    public function checkout_orders(Request $request)
    {
        $id = DB::table('transaksi_total')->insertGetId([
            'id_member' => $request->id_member,
            'invoice' => date('ymds'),
            'total_harga' => $request->cart_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        for($i = 0; $i < count($request->id_produk); $i++) {
            DB::table('transaksi_detail')->insert([
                'id_td' => $id,
                'id_produk' => $request->id_produk[$i],
                'jumlah' => $request->jumlah[$i],
                'harga' => $request->total[$i],
            ]);
        }

        Keranjang::where('id_member', Auth::guard('webmember')->user()->id)->update([
            'is_checkout' => 1
        ]);

    }

    public function checkout()
    {

        // $about = About::first();
        $orders = transaksi_total::where('id_member', Auth::guard('webmember')->user()->id)->latest()->first();
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "key: 1adb8efa384245ff3bc71d4d2429518a"
        //     ),
        // ));

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // }

        // $provinsi = json_decode($response);
        return view('home.checkout', compact('orders'));
    }

    // public function payments(Request $request)
    // {
    //     Payment::create([
    //         'id_order' => $request->id_order,
    //         'id_member' => Auth::guard('webmember')->user()->id,
    //         'jumlah' => $request->jumlah,
    //         'provinsi' => $request->provinsi,
    //         'kabupaten' => $request->kabupaten,
    //         'kecamatan' => "",
    //         'detail_alamat' => $request->detail_alamat,
    //         'status' => 'Pending',
    //         'no_rekening' => $request->no_rekening,
    //         'atas_nama' => $request->atas_nama,
    //     ]);
    //     return redirect('/orders');
    // }

    public function orders()
    {
        $orders = transaksi_total::where('id_member', Auth::guard('webmember')->user()->id)->get();
        // $payments = Payment::where('id_member', Auth::guard('webmember')->user()->id)->get();
        return view('home.orders', compact('orders'));
    }

    public function about()
    {
        $about = About::first();
        $testimonies = Testimoni::all();
        return view('home.about', compact('about', 'testimonies'));
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function faq()
    {
        return view('home.faq');
    }

    
}
