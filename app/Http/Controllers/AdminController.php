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
        $product = product::find($id);
        return view('landing.checkout', compact(['product']));
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
                return redirect()->route('admin/product');
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

    public function listCategorys() {
            $list_categorys = CategoryProduct::where('state', 1)->get();
            return view('admin.list-category-product', compact(['list_categorys']));
    }

    public function getProducts($category_name) {
        $category = CategoryProduct::where('name', $category_name)->first();
        $list_products = Product::where('id_product_category',$category->id)->get();
        return view('admin.list-product', compact(['list_products','category']));
    }

    public function downloadFile($model, $id){
        $pathtoFile = "";
        switch ($model) {
            case 1:
                $product = Product::find($id);
                $pathtoFile = public_path().'/storage/files/products/'.$product->url_image;
                break;
            
            default:
                $pathtoFile = "";
                break;
        }

        return response()->download($pathtoFile);
    }

    public function createCategory(Request $request){
        $data = $request->all();
        if($data){
            $data = (object) $data;
            $new_cg_product = new CategoryProduct;
            $new_cg_product->fill($request->all());
            $new_cg_product->state = 1;

            $message = "";
            if($new_cg_product->save()){
                $message = "Categoria Creada Correctamente";
                session()->flash('message_cg_product_success', $message);
            }else{
                $message = "Ocurrió un error, intente nuevamente";
                session()->flash('message_cg_product_error', $message);
            }

            return redirect()->route('admin/product');
        }
        return view('admin.create-category-product');
    }


    public function editCategory(Request $request, $category_name){
        $category = CategoryProduct::where('name', $category_name)->first();;
        $message = "";
        if($category){
            $data = $request->all();
            if($data){
                $data = (object) $data;
                $category->fill($request->all());
                $category->state = 1;
    
                if($category->update()){
                    $message = "Categoria actualizada correctamente";
                    session()->flash('message_cg_room_sucess', $message);
                }else{
                    $message = "Ocurrió un error, intente nuevamente";
                    session()->flash('message_cg_product_error', $message);
                }
    
                return redirect()->route('admin/product');
            }
            return view('admin.edit-category-product', compact(['category']));
        }else{
            $message = "El registro que intenta editar no existe";
            session()->flash('message_cg_product_error', $message);
            return redirect()->route('admin/product');
        }
    }

    public function editProduct(Request $request,$id){
        $product = Product::find($id);
        $category= $product->category; 
        $message = "";
        if($product){
            $data = $request->all();
            if($data){
                $data = (object) $data;
                $file = $request->file('file_product');

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

                    if($room->url_image != null){
                        Storage::delete($path_files_product.$product->url_image);
                    }

                    $extension = '.'.$file->getClientOriginalExtension();
                    $url = Str::random(16);
                    $url .= $extension;
                    $product->url_image = $url;
                }
    
                $product->fill($request->all());
                $product->state = 1;
    
                if($product->update()){
                    if($file){
                        Storage::put($path_files_product.$url, \File::get($file));
                    }
                    $message = "Producto actualizado correctamente";
                    session()->flash('message_product_sucess', $message);
                }else{
                    $message = "Ocurrió un error, intente nuevamente";
                    session()->flash('message_product_error', $message);
                }
    
                return redirect()->route('getProducts',$category->name);
            }

            $list_category_product = CategoryProduct::where('state', 1)->get();
            return view('admin.edit-product', compact(['list_category_product', 'product','category']));
        }else{
            $message = "El producto que intenta editar no existe";
            session()->flash('message_product_error', $message);
            return redirect()->route('admin/product');
        }
    }


    public function createProduct(Request $request,$category_name){
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
                    Storage::put($path_files_product.$url, \File::get($file));
                }
                $message = "Habitación registrada Correctamente";
                session()->flash('message_product_sucess', $message);
            }else{
                $message = "Ocurrió un error, intente nuevamente";
                session()->flash('message_product_error', $message);
            }

            return redirect()->route('getProducts',$category_name);
        }
        $category = CategoryProduct::where('name', $category_name)->first();
        $list_categorys = CategoryProduct::where('state', 1)->get();
        return view('admin.create-product', compact(['category','list_categorys']));
    }

    public function listCategoryProduct() {
        $list_category_product = CategoryProduct::where('state', 1)->get();
        return view('admin.list-category-product', compact(['list_category_product']));
    }

}