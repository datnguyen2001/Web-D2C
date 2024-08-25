<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ProductDiscountsModel;
use App\Models\ProductsAttributeModel;
use App\Models\ProductsModel;
use App\Models\ShopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopController extends Controller
{
    public function detailShop($id){
        try{
            $data = DB::table('shop as s')
                ->join('province as p', 's.province_id', '=', 'p.province_id')
                ->join('district as d', 's.district_id', '=', 'd.district_id')
                ->join('wards as w', 's.ward_id', '=', 'w.wards_id')
                ->where('s.id', $id)
                ->select(
                    's.*',
                    DB::raw("CONCAT(s.address_detail, ', ', w.name, ', ', d.name, ', ', p.name) as full_address")
                )
                ->first();
            if ($data->display == 0){
                return response()->json(['message'=>'Cửa hàng của bạn đã bị xóa','status'=>true]);
            }
            return response()->json(['message'=>'Lấy dữ liệu thành công','data'=>$data,'status'=>true]);

        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }

    public function getShop(){
        try{
            $user = JWTAuth::user();
            $data = ShopModel::where('user_id',$user->id)->first();
            $data->src = json_decode($data->src, true);
            if ($data->display == 0){
                return response()->json(['message'=>'Cửa hàng của bạn đã bị xóa','status'=>true]);
            }
            return response()->json(['message'=>'Lấy dữ liệu thành công','data'=>$data,'status'=>true]);

        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }

    public function createShop(Request $request)
    {
        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $avatar = Storage::url($file->store('shop', 'public'));
            }else{
                return response()->json(['message' => 'Vui lòng thêm ảnh avatar', 'status' => false]);
            }
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $banner = Storage::url($file->store('shop', 'public'));
            }else{
                return response()->json(['message' => 'Vui lòng thêm ảnh avatar', 'status' => false]);
            }
            if ($request->hasFile('src')) {
                foreach ($request->file('src') as $file) {
                    $imagePath = Storage::url($file->store('shop', 'public'));
                    $srcArray[] = $imagePath;
                }
            }else{
                return response()->json(['message' => 'Vui lòng thêm ảnh shop', 'status' => false]);
            }
            $user = JWTAuth::user();
            $shop = new ShopModel();
            $shop->user_id = $user->id;
            $shop->name = $request->get('name');
            $shop->phone = $request->get('phone');
            $shop->email = $request->get('email');
            $shop->scope = $request->get('scope');
            $shop->province_id = $request->get('province_id');
            $shop->district_id = $request->get('district_id');
            $shop->ward_id = $request->get('ward_id');
            $shop->address_detail = $request->get('address_detail');
            $shop->content = $request->get('content');
            $shop->avatar = $avatar;
            $shop->banner = $banner;
            $shop->src = json_encode($srcArray);
            $shop->save();

            return response()->json(['message' => 'Tạo cửa hàng thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }
    public function updateShop(Request $request)
    {
        try {
            $user = JWTAuth::user();
            $shop = ShopModel::where('user_id',$user->id)->first();
            if ($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $avatar = Storage::url($file->store('shop', 'public'));
                if (isset($shop->avatar) && Storage::exists(str_replace('/storage', 'public', $shop->avatar))) {
                    Storage::delete(str_replace('/storage', 'public', $shop->avatar));
                }
                $shop->avatar = $avatar;
            }
            if ($request->hasFile('banner')){
                $file = $request->file('banner');
                $banner = Storage::url($file->store('shop', 'public'));
                if (isset($shop->banner) && Storage::exists(str_replace('/storage', 'public', $shop->banner))) {
                    Storage::delete(str_replace('/storage', 'public', $shop->banner));
                }
                $shop->banner = $banner;
            }
            $existingSrc = json_decode($shop->src, true) ?? [];
            $newSrcArray = [];
            if ($request->hasFile('src')) {
                foreach ($request->file('src') as $file) {
                    $imagePath = Storage::url($file->store('shop', 'public'));
                    $newSrcArray[] = $imagePath;
                }
                $finalSrcArray = array_merge($existingSrc, $newSrcArray);
                $shop->src = json_encode($finalSrcArray);
            }
            if ($request->has('name')) {
                $shop->name = $request->get('name');
            }
            if ($request->has('phone')) {
                $shop->phone = $request->get('phone');
            }
            if ($request->has('email')) {
                $shop->email = $request->get('email');
            }
            if ($request->has('scope')) {
                $shop->scope = $request->get('scope');
            }
            if ($request->has('province_id')) {
                $shop->province_id = $request->get('province_id');
            }
            if ($request->has('district_id')) {
                $shop->district_id = $request->get('district_id');
            }
            if ($request->has('ward_id')) {
                $shop->ward_id = $request->get('ward_id');
            }
            if ($request->has('address_detail')) {
                $shop->address_detail = $request->get('address_detail');
            }
            if ($request->has('content')) {
                $shop->content = $request->get('content');
            }
            $shop->save();

            return response()->json(['message' => 'Cập nhật cửa hàng thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function deleteSrcShop(Request $request)
    {
        try {
            $user = JWTAuth::user();
            $shop = ShopModel::where('user_id',$user->id)->first();
            if (!$shop) {
                return response()->json(['message' => 'Shop không tồn tại', 'status' => false]);
            }
            $existingSrc = json_decode($shop->src, true) ?? [];
            $imagesToDelete = json_decode($request->input('src', []));
            $remainingSrc = array_diff($existingSrc, $imagesToDelete);
            $remainingSrc = array_values($remainingSrc);
            $shop->src = json_encode($remainingSrc);
            $shop->save();
            foreach ($imagesToDelete as $image) {
                $filePath = str_replace('/storage', 'public', $image);
                Storage::delete($filePath);
            }

            return response()->json(['message' => 'Xóa ảnh shop thành công', 'status' => true]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function getProduct()
    {
        try {
            $user = JWTAuth::user();
            $shop = ShopModel::where('user_id', $user->id)->first();
            $data = DB::table('products as p')
                ->join(DB::raw("
                (SELECT product_id, quantity, price
                FROM products_attribute
                WHERE (product_id, quantity) IN (
                    SELECT product_id, MIN(quantity)
                    FROM products_attribute
                    GROUP BY product_id
                )) pa
            "), 'p.id', '=', 'pa.product_id')
                ->where('p.shop_id', $shop->id)
                ->select(
                    'p.id',
                    'p.name',
                    'p.name_en',
                    'p.slug',
                    'p.sku',
                    'p.category_id',
                    'p.unit',
                    'p.en_unit',
                    'p.quantity',
                    'p.display',
                    'p.status',
                    'p.src',
                    'pa.quantity as min_quantity',
                    'pa.price as price'
                )
                ->paginate(20);
            foreach ($data as $item) {
                $item->src = json_decode($item->src, true);
            }

            return response()->json(['message' => 'Lấy dữ liệu thành công', 'data' => $data, 'status' => true]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function createProduct(Request $request)
    {
        try {
            $user = JWTAuth::user();
            $shop = ShopModel::where('user_id', $user->id)->first();
            $translator = new GoogleTranslate();
            $translator->setSource('vi');
            $translator->setTarget('en');
            $translatedName = $translator->translate($request->get('name'));
            $translatedUnit = $translator->translate($request->get('unit'));
            $product = new ProductsModel();
            $product->name = $request->get('name');
            $product->name_en = $translatedName;
            $product->slug = Str::slug($request->get('name'));
            $product->sku = $request->get('sku');
            $product->describe = $request->get('describe');
            $product->category_id = $request->get('category_id');
            $product->unit = $request->get('unit');
            $product->en_unit = $translatedUnit;
            $product->contact_info = $request->get('contact_info');
            $product->minimum_quantity = $request->get('minimum_quantity');
            $srcArray = [];
            if ($request->hasFile('src')) {
                foreach ($request->file('src') as $file) {
                    $imagePath = Storage::url($file->store('products', 'public'));
                    $srcArray[] = $imagePath;
                }
            }
            $product->src = json_encode($srcArray);
            $product->quantity = $request->get('quantity');
            $product->shop_id = $shop->id;
            $product->display = 1;
            $product->status = 0;
            $product->save();

            $attributes = json_decode($request->get('attributes'), true);
            if (is_array($attributes)) {
                foreach ($attributes as $attribute) {
                    $data = new ProductsAttributeModel();
                    $data->product_id = $product->id;
                    $data->quantity = $attribute['quantity'];
                    $data->price = $attribute['price'];
                    $data->save();
                }
            }

            return response()->json(['message' => 'Thêm sản phẩm thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => true]);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $translator = new GoogleTranslate();
            $translator->setSource('vi');
            $translator->setTarget('en');

            $product = ProductsModel::find($id);
            if ($request->has('name')) {
                $product->name = $request->get('name');
                $product->name_en = $translator->translate($request->get('name'));
                $product->slug = Str::slug($request->get('name'));
            }
            if ($request->has('sku')) {
                $product->sku = $request->get('sku');
            }
            if ($request->has('describe')) {
                $product->describe = $request->get('describe');
            }
            if ($request->has('category_id')) {
                $product->category_id = $request->get('category_id');
            }
            if ($request->has('unit')) {
                $product->unit = $request->get('unit');
                $product->en_unit = $translator->translate($request->get('unit'));
            }
            if ($request->has('contact_info')) {
                $product->contact_info = $request->get('contact_info');
            }
            if ($request->has('minimum_quantity')) {
                $product->minimum_quantity = $request->get('minimum_quantity');
            }
            if ($request->has('quantity')) {
                $product->quantity = $request->get('quantity');
            }
            $existingSrc = json_decode($product->src, true) ?? [];
            $newSrcArray = [];
            if ($request->hasFile('src')) {
                foreach ($request->file('src') as $file) {
                    $imagePath = Storage::url($file->store('products', 'public'));
                    $newSrcArray[] = $imagePath;
                }
                $finalSrcArray = array_merge($existingSrc, $newSrcArray);
                $product->src = json_encode($finalSrcArray);
            }
            $product->save();

            $attributes = json_decode($request->get('attributes'), true);
            if (is_array($attributes)) {
                foreach ($attributes as $attribute) {
                    if (isset($attribute['id'])) {
                        $data = ProductsAttributeModel::find($attribute['id']);
                        $data->product_id = $product->id;
                        $data->quantity = $attribute['quantity'];
                        $data->price = $attribute['price'];
                        $data->save();
                    } else {
                        $data = new ProductsAttributeModel();
                        $data->product_id = $product->id;
                        $data->quantity = $attribute['quantity'];
                        $data->price = $attribute['price'];
                        $data->save();
                    }
                }
            }

            return response()->json(['message' => 'Cập nhật sản phẩm thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $data = ProductsModel::find($id);
            if (!$data) {
                return response()->json(['message' => 'Sản phẩm không tồn tại', 'status' => false]);
            }
            $imagesToDelete = json_decode($data->src, true) ?? [];
            foreach ($imagesToDelete as $image) {
                $filePath = str_replace('/storage', 'public', $image);
                Storage::delete($filePath);
            }
            $data->delete();

            return response()->json(['message' => 'Xóa sản phẩm thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function deleteProductAttribute($id)
    {
        try {
            $data = ProductsAttributeModel::find($id);
            if (!$data) {
                return response()->json(['message' => 'Thuộc tính không tồn tại', 'status' => false]);
            }
            $data->delete();

            return response()->json(['message' => 'Xóa thuộc tính sản phẩm thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function deleteProductImage(Request $request, $id)
    {
        try {
            $product = ProductsModel::find($id);
            if (!$product) {
                return response()->json(['message' => 'Sản phẩm không tồn tại', 'status' => false]);
            }
            $existingSrc = json_decode($product->src, true) ?? [];
            $imagesToDelete = json_decode($request->input('src', []));
            $remainingSrc = array_diff($existingSrc, $imagesToDelete);
            $remainingSrc = array_values($remainingSrc);
            $product->src = json_encode($remainingSrc);
            $product->save();
            foreach ($imagesToDelete as $image) {
                $filePath = str_replace('/storage', 'public', $image);
                Storage::delete($filePath);
            }

            return response()->json(['message' => 'Xóa ảnh sản phẩm thành công', 'status' => true]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function updateProductDisplay(Request $request, $id)
    {
        try {
            $product = ProductsModel::find($id);
            if (!$product) {
                return response()->json(['message' => 'Sản phẩm không tồn tại', 'status' => false]);
            }
            $product->display = $request->get('display');
            $product->save();

            return response()->json(['message' => 'Cập nhật trạng thái sản phẩm thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function detailProductShop($id)
    {
        try {
            $product = ProductsModel::find($id);
            $product->src = json_decode($product->src, true);
            $product_attribute = ProductsAttributeModel::where('product_id',$id)->get();
            $discounts = ProductDiscountsModel::where('product_id', $id)->first();
            $response = [
                'product' => $product,
                'product_attribute' => $product_attribute,
                'discounts' => $discounts
            ];

            return response()->json(['message' => 'Lấy chi tiết sản phẩm thành công', 'data' => $response, 'status' => true]);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function setProductDiscount(Request $request, $id)
    {
        try {
            $product = ProductsModel::find($id);
            if (!$product) {
                return response()->json(['message' => 'Sản phẩm không tồn tại', 'status' => false]);
            }
            $data = ProductDiscountsModel::where('product_id',$product->id)->first();
            if (isset($data)){
                $data->date_start = $request->get('date_start');
                $data->date_end = $request->get('date_end');
                $data->number = $request->get('number');
                $data->discount = $request->get('discount');
                $data ->save();
            }else{
                $discounts = new ProductDiscountsModel();
                $discounts->product_id = $product->id;
                $discounts->date_start = $request->get('date_start');
                $discounts->date_end = $request->get('date_end');
                $discounts->number = $request->get('number');
                $discounts->discount = $request->get('discount');
                $discounts->save();
            }

            return response()->json(['message' => 'Tạo sản phẩm giảm giá thành công', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function searchProductShop(Request $request){
        try{
            $user = JWTAuth::user();
            $shop = ShopModel::where('user_id', $user->id)->first();
            $searchTerm = $request->input('search', '');
            $query = DB::table('products as p')
                ->join(DB::raw("
                (SELECT product_id, quantity, price
                FROM products_attribute
                WHERE (product_id, quantity) IN (
                    SELECT product_id, MIN(quantity)
                    FROM products_attribute
                    GROUP BY product_id
                )) pa
            "), 'p.id', '=', 'pa.product_id')
                ->where('p.shop_id', $shop->id)
                ->select(
                    'p.id',
                    'p.name',
                    'p.name_en',
                    'p.slug',
                    'p.sku',
                    'p.category_id',
                    'p.unit',
                    'p.en_unit',
                    'p.quantity',
                    'p.display',
                    'p.status',
                    'p.src',
                    'pa.price as price'
                );

            if ($searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('p.name', 'LIKE', "%$searchTerm%")
                        ->orWhere('p.sku', 'LIKE', "%$searchTerm%");
                });
            }
            $data = $query->paginate(20);
            foreach ($data as $item) {
                $item->src = json_decode($item->src, true);
            }

            return response()->json(['message'=>'Tìm kiếm sản phẩm thành công','data'=>$data,'status'=>true]);

        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }

}
