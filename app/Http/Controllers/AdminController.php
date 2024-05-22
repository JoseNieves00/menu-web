<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryProduct;
use App\Models\CategoryTopping;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductVersion;
use App\Models\Toppings;



class AdminController extends Controller
{
    public function index() {
        $list_category = Category::where('state', 1)->get();
        return view('index', compact(['list_category']));
    }

    public function carrito(){
        return view('carrito');
    }

    public function checkout($id) {
        $product = product::find($id);
        return view('landing.checkout', compact(['product']));
    }

    public function getCategoryProducts($id) {
        $category = Category::find($id);
        $list_products = Product::where('id_product_category', $id)->get();
        $idProducts = $list_products->pluck('id');
        $list_version = ProductVersion::whereIn('id_product', $idProducts)->get();
        return view('products', compact('list_products', 'list_version',));
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
                return redirect()->route('admin/categorys');
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
            $list_categorys = Category::where('state', 1)->get();
            return view('admin.list-category-product', compact(['list_categorys']));
    }

    public function listTopping() {
        $list_topping = Toppings::where('state', 1)->get();
        return view('admin.list-topping', compact(['list_topping']));
}

    public function getProducts($id) {
        $category = Category::find($id);
        $categoryProduct= CategoryProduct::where('id_category', $id)->get();
        $list_product_ids = $categoryProduct->pluck('id_product');
        $list_products = Product::whereIn('id', $list_product_ids)->get();
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

    public function createTopping(Request $request){
        $data = $request->all();
        $message = "";
        if($data){
            DB::beginTransaction();

            $data = (object) $data;
            $new_topping = new Toppings;
            $new_topping->fill($request->all());
            $new_topping->state = 1;

            $save_topping = $new_topping->save();
            $save_category_topping = false;

            if($save_topping){
                if(count($data->categories)>0){
                    foreach ($data->categories as $item) {
                        $new_category_topping = new CategoryTopping;
                        $new_category_topping->id_topping=$new_topping->id;
                        $new_category_topping->id_category=$item;
        
                        if($new_category_topping->save()){
                            $save_category_topping = true;
                        } else {
                            $save_category_topping = false;
                            break;
                        }
                    }
                } else {
                    $save_category_topping = true;
                }
            }
            
            if($save_topping && $save_category_topping){
                DB::commit();
                $message = "Topping Creado Correctamente";
                session()->flash('message_cg_product_success', $message);
            } else {
                DB::rollback();
                $message = "Ocurrió un error, intente nuevamente";
                session()->flash('message_cg_product_error', $message);
            }

            return redirect()->route('admin/toppings');
        }
        $list_categorys = Category::where('state', 1)->get();
        return view('admin.create-topping', compact(['list_categorys']));
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

            return redirect()->route('admin/categorys');
        }
        return view('admin.create-category-product');
    }


    public function editCategory(Request $request, $id){
        $category = Category::find($id);
        $message = "";
        if($category){
            $data = $request->all();
            if($data){
                $data = (object) $data;
                $category->fill($request->all());
                $category->state = 1;
    
                if($category->update()){
                    $message = "Categoria actualizada correctamente";
                    session()->flash('message_cg_product_success', $message);
                }else{
                    $message = "Ocurrió un error, intente nuevamente";
                    session()->flash('message_cg_product_error', $message);
                }
    
                return redirect()->route('admin/categorys');
            }
            return view('admin.edit-category-product', compact(['category']));
        }else{
            $message = "El registro que intenta editar no existe";
            session()->flash('message_cg_product_error', $message);
            return redirect()->route('admin/categorys');
        }
    }

    public function editProductVersion(Request $request, $id){
        $productVersion = productVersion::find($id);
        $message = "";
        $error = true;

        if($productVersion){
            if($request->all()){
                $productVersion->fill($request->all());
                $productVersion->state = 1;
    
                if($productVersion->update()){
                    $message = "Versión actualizada correctamente";
                    $error=false;
                }else{
                    $message = "Ocurrió un error, intente nuevamente";
                }
            }
        }else{
            $message = "La versión que intenta editar no existe";
        }
        return response()->json([
            "error"=>$error,
            "message"=>$message
        ]);
    }

    public function createProductVersion(Request $request,$id){
        $message = "";
        $error = true;
        if($request->all()){
            dd($request);
            DB::beginTransaction();

            $new_productVersion = new ProductVersion;
            $new_productVersion->fill($request->all());
            $new_productVersion->state = 1;

            $save_productVersion = $product->save();
            $save_config_product_version = false;

            if($save_productVersion){
                $new_productVersion = new ProductVersion;
                $new_productVersion->id_product_version=$new_product->id;
                $new_productVersion->id_category_topping=$request->id_product_category;
                $new_productVersion->max_limit=$data->max_limit;
                

                if($new_productVersion->save()){
                    $save_productVersion = true;
                } else {
                    $save_productVersion = false;
                }
            }

            if($new_productVersion->save()){
                $message = "Versión guardada correctamente";
                $error=false;
            }else{
                $message = "Ocurrió un error, intente nuevamente";
            }

        }
        return response()->json([
            "error"=>$error,
            "message"=>$message
        ]);
    }

    public function getToppings(Request $request,$id){
        dd($id);
    }


    public function getCategoryToppings(Request $request,$id){
        $category = Category::find($id);
        $message = "La categoria no existe";
        $error = true;
        if($category){
            $message = "ok";
            $category->categoriesTopping;
            $error = false;
        }

        return response()->json([
            "error" => $error,
            "message" => $message,
            "category" => $category
        ]);
    }

    public function editTopping(Request $request, $id){
        $topping = Toppings::find($id);
        $message = "";
        if($topping){
            $data = $request->all();
            if($data){
                DB::beginTransaction();
                $data = (object) $data;
                $topping->fill($request->all());
                $topping->state = 1;
    
                $update_topping = $topping->update();
                $save_category_topping = false;

                foreach ($topping->categoriesTopping as $value) {
                    $value->delete();
                }
    
                if($update_topping){
                    if(count($data->categories)>0){
                        foreach ($data->categories as $item) {
                            $new_category_topping = new CategoryTopping;
                            $new_category_topping->id_topping=$topping->id;
                            $new_category_topping->id_category=$item;
            
                            if($new_category_topping->save()){
                                $save_category_topping = true;
                            } else {
                                $save_category_topping = false;
                                break;
                            }
                        }
                    } else {
                        $save_category_topping = true;
                    }
                }
                
                if($update_topping && $save_category_topping){
                    DB::commit();
                    $message = "Topping actualizado Correctamente";
                    session()->flash('message_cg_product_success', $message);
                } else {
                    DB::rollback();
                    $message = "Ocurrió un error, intente nuevamente";
                    session()->flash('message_cg_product_error', $message);
                }
    
                return redirect()->route('admin/toppings');
            }
            $list_categorys = Category::where('state', 1)->get();
            return view('admin.edit-topping', compact(['topping','list_categorys']));
        }else{
            $message = "El registro que intenta editar no existe";
            session()->flash('message_cg_product_error', $message);
            return redirect()->route('admin/toppings');
        }
    }

    public function editProduct(Request $request, $id)
    {
        $product = Product::with('category')->find($id);
        $idCategory = $product->id_product_category;
        $category = Category::find($idCategory);
        $message = "";
        if ($product) {
            $data = $request->all();
    
            if ($data) {
                DB::beginTransaction();
    
                $data = (object) $data;
                $product->fill($request->all());
                $product->state = 1;
    
                $update_product = $product->update();
                $save_category_product = false;

                CategoryProduct::where('id_product',$id)->delete();
                
                if($update_product){
                    $new_category_product = new CategoryProduct;
                    $new_category_product->id_product=$product->id;
                    $new_category_product->id_category=$product->id_product_category;
    
                    if($new_category_product->save()){
                        $save_category_product = true;
                    } else {
                        $save_category_product = false;
                    }
                }
    
                if ($update_product && $save_category_product) {
                    DB::commit();
                    $message = "Producto Actualizado Correctamente";
                    session()->flash('message_product_success', $message);
                } else {
                    DB::rollback();
                    $message = "Ocurrió un error, intente nuevamente";
                    session()->flash('message_product_error', $message);
                }
    
                return redirect()->route('admin/products',$product->id_product_category);
            }
    
            $list_category_product = Category::where('state', 1)->get();
            $list_version = productVersion::where('id_product', $id)->get();
    
            return view('admin.edit-product', compact(['list_category_product', 'product', 'list_version','category']));
        } else {
            $message = "El producto que intenta editar no existe";
            session()->flash('message_product_error', $message);
            return redirect()->route('admin/categorys');
        }
    }
    


    public function createProduct(Request $request,$id){
        $data = $request->all();
        $message = "";
        if($data){
            DB::beginTransaction();

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

            $save_product = $new_product->save();
            $save_category_product = false;

            if($save_product){
                $new_category_product = new CategoryProduct;
                $new_category_product->id_product=$new_product->id;
                $new_category_product->id_category=$data->id_product_category;

                if($new_category_product->save()){
                    $save_category_product = true;
                } else {
                    $save_category_product = false;
                }
            }
            
            if($save_product && $save_category_product){
                DB::commit();
                if($file){
                    Storage::put($path_files_product.$url, \File::get($file));
                }
                $message = "Producto Creado Correctamente";
                session()->flash('message_product_success', $message);
            } else {
                DB::rollback();
                $message = "Ocurrió un error, intente nuevamente";
                session()->flash('message_product_error', $message);
            }


            return redirect()->route('admin/products',$id);
        }
    $category = Category::find($id);
    $toppings = Toppings::where('state', 1)->get();
    $list_categorys = Category::where('state', 1)->get();
    return view('admin.create-product', compact('category', 'list_categorys', 'toppings'));
    }

    public function listCategoryProduct() {
        $list_category_product = CategoryProduct::where('state', 1)->get();
        return view('admin.list-category-product', compact(['list_category_product']));
    }

}