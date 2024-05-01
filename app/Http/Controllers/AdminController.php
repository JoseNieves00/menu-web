<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\User;


class AdminController extends Controller
{
    public function index() {
        $list_category = CategoryProduct::where('state', 1)->where('is_principal',1)->get();
        return view('index', compact(['list_category']));
    }

    public function carrito(){
        return view('carrito');
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

    public function login(Request $request){
        $data = $request->all();
        if($data){
            $data = (object) $data;
            $user = User::where('username', $data->username)->where('password', md5($data->password))->first();
            if($user){
                session([
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username
                ]);
                return redirect()->route('admin/products');
            }else{
                $message = "Credenciales invalidas";
                session()->flash('message_credentials_invalid', $message);
                return redirect()->route('admin');
            }
            dd($user);
        }
        return view('auth.login');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('admin');
    }

    public function listProducts() {
        $list_products = Product::where('state', 1)->get();
        return view('admin.list-product', compact(['list_products']));
    }

    public function createProduct(Request $request){
        $data = $request->all();
        if($data){
            $data = (object) $data;
            $file = $request->file('file_product');
            $new_product = new Product;
            $url = null;
            if($file){
                $path_files = "/public/files/";
                if(!Storage::exists($path_files)) {
                    Storage::makeDirectory($path_files, 0755);
                }
                $path_files_product = "/public/files/products/";
                if(!Storage::exists($path_files_product)) {
                    Storage::makeDirectory($path_files_product, 0755);
                }
                $extension = '.'.$file->getClientOriginalExtension();
                $url = Str::random(16);
                $url .= $extension;
            }

            $new_product->fill($request->all());
            $new_product->url_image = $url;
            $new_product->state = 1;

            $message = "";
            if($new_product->save()){
                if($file){
                    Storage::put($path_files_room.$url, \File::get($file));
                }
                $message = "Habitación registrada Correctamente";
                session()->flash('message_product_sucess', $message);
            }else{
                $message = "Ocurrió un error, intente nuevamente";
                session()->flash('message_product_error', $message);
            }

            return redirect()->route('admin/product');
        }
        $list_category_product = CategoryProduct::where('state', 1)->get();
        return view('admin.create-product', compact(['list_category_product']));
    }

    public function listCategoryProduct() {
        $list_category_product = CategoryProduct::where('state', 1)->get();
        return view('admin.list-category-product', compact(['list_category_product']));
    }

}