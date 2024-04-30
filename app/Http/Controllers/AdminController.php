<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryProduct;
use App\Models\Product;

class AdminController extends Controller
{
    public function index() {
        $list_category = CategoryProduct::where('state', 1)->where('is_principal',1)->get();
        return view('index', compact(['list_category']));
    }

    public function carrito(){
        return view('carrito');
    }

    public function getPrices(Request $request) {
        $error = true;
        dd($request);
        $message = '';
        $data = $request->all();
        $list = [];
        // if($data){
        //     $data = (object) $data;

        //     $room = Room::where('id_room_category', $data->id_category_room)->where('limit_person', $data->total_person)->get();
        //     if(!$room){
        //         $message = "No tenemos habitaciones con las caracteristicas seleccionadas";
        //     }else{
        //         $list = $room;
        //         $message = "Ok"; 
        //         $error = false;
        //     }
        // }else{
        //     $message = "Ocurrió un error, intentelo nuevamente";
        // }

        // return response()->json([
        //     "error" => $error,
        //     "message" => $message,
        //     "list" => $list
        // ]);
    }

    public function checkout($id) {
        $room = Room::find($id);
        return view('landing.checkout', compact(['room']));
    }

    public function getCategoryProducts($category_name) {
        $category = CategoryProduct::where('name', $category_name)->first();
        $list_products = Product::where('id_product_category',$category->id)->get();
        return view('products', compact(['list_products']));
    }
}