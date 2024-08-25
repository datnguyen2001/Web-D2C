<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductDiscountsModel;
use App\Models\ProductsAttributeModel;
use App\Models\ProductsModel;
use App\Models\ShopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $titlePage = 'Admin | Danh Sách Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;

        $user = Auth::guard('web')->user();
        $shop = ShopModel::where('user_id',$user->id)->first();
        $listData = DB::table('products as p')
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
                'p.created_at',
                'pa.quantity as min_quantity',
                'pa.price as price'
            )
            ->paginate(20);
        foreach ($listData as $item) {
            $item->src = json_decode($item->src, true);
            $item->category_name = CategoryModel::find($item->category_id)->name;
        }
        return view('shop.product.index', compact('titlePage', 'page_menu', 'listData', 'page_sub'));
    }

    public function create()
    {
        $titlePage = 'Admin | Thêm Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;
        $category = CategoryModel::where('display', 1)->get();
        return view('shop.product.create', compact('titlePage', 'page_menu', 'page_sub', 'category'));
    }

    public function store(Request $request)
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
            $product->describe = $request->get('content');
            $product->category_id = $request->get('category_id');
            $product->unit = $request->get('unit');
            $product->en_unit = $translatedUnit;
            $product->contact_info = $request->get('contact_info');
            $product->minimum_quantity = $request->get('minimum_quantity');
            $srcArray = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
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

            $attributes = $request->get('variant');
            if (is_array($attributes)) {
                foreach ($attributes as $attribute) {
                    $data = new ProductsAttributeModel();
                    $data->product_id = $product->id;
                    $data->quantity = $attribute['name'];
                    $data->price = str_replace(",", "", $attribute['price']);
                    $data->save();
                }
            }

            return \redirect()->route('shop.product.index')->with(['success' => 'Tạo mới sản phẩm thành công']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function edit($id)
    {
        $titlePage = 'Admin | Sửa Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;
        $category = CategoryModel::where('display', 1)->get();
        $product = ProductsModel::find($id);
        $product->src = json_decode($product->src, true);
        $product_attribute = ProductsAttributeModel::where('product_id',$id)->get();

        return view('shop.product.edit', compact('titlePage', 'page_menu', 'page_sub', 'category','product','product_attribute'));
    }

    public function update(Request $request, $id)
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
            if ($request->has('content')) {
                $product->describe = $request->get('content');
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
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $imagePath = Storage::url($file->store('products', 'public'));
                    $newSrcArray[] = $imagePath;
                }
                $finalSrcArray = array_merge($existingSrc, $newSrcArray);
                $product->src = json_encode($finalSrcArray);
            }
            $product->save();

            $attributes = $request->get('variant');
            if (is_array($attributes)) {
                foreach ($attributes as $attribute) {
                    if (isset($attribute['attribute_id'])) {
                        $data = ProductsAttributeModel::find($attribute['attribute_id']);
                        $data->product_id = $product->id;
                        $data->quantity = $attribute['name'];
                        $data->price = str_replace(",", "", $attribute['price']);
                        $data->save();
                    } else {
                        $data = new ProductsAttributeModel();
                        $data->product_id = $product->id;
                        $data->quantity = $attribute['name'];
                        $data->price = str_replace(",", "", $attribute['price']);
                        $data->save();
                    }
                }
            }

            toastr()->success('Cập nhật sản phẩm thành công');
            return redirect()->route('shop.product.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($id)
    {
        $data = ProductsModel::find($id);
        $imagesToDelete = json_decode($data->src, true) ?? [];
        foreach ($imagesToDelete as $image) {
            $filePath = str_replace('/storage', 'public', $image);
            Storage::delete($filePath);
        }
        $data->delete();
        toastr()->success('Xóa dữ liệu thành công');
        return back();
    }

    public function deleteImg(Request $request)
    {
        $product = ProductsModel::find($request->get('id'));
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại', 'status' => false]);
        }
        $existingSrc = json_decode($product->src, true) ?? [];
        $imagesToDelete = [$request->get('src')];
        $remainingSrc = array_diff($existingSrc, $imagesToDelete);
        $remainingSrc = array_values($remainingSrc);
        $product->src = json_encode($remainingSrc);
        $product->save();
        foreach ($imagesToDelete as $image) {
            $filePath = str_replace('/storage', 'public', $image);
            Storage::delete($filePath);
        }
        toastr()->success('Xóa ảnh thành công');
        return response()->json(['status'=>true]);
    }

    public function deletePrice($id)
    {
        try {
            $data = ProductsAttributeModel::find($id);
            if (!$data) {
                toastr()->error('Thuộc tính không tồn tại');
                return back();
            }
            $data->delete();

            toastr()->success('Xóa thuộc tính sản phẩm thành công');
            return back();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function variantPrice(Request $request)
    {
        $count = $request->get('count');
        $view = view('shop.product.variant-color', compact('count'))->render();
        return \response()->json(['html' => $view, 'count' => $count]);
    }

    public function discount($id)
    {
        $titlePage = 'Admin | Cấu Hình Sản Phẩm Giảm Giá';
        $page_menu = 'product';
        $page_sub = null;
        $product = ProductDiscountsModel::where('product_id',$id)->first();

        return view('shop.product.discount', compact('titlePage', 'page_menu', 'page_sub','product','id'));
    }

    public function updateDiscount(Request $request, $id)
    {
        try {
            $product = ProductsModel::find($id);
            if (!$product) {
                toastr()->error('Sản phẩm không tồn tại');
                return back();
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

            toastr()->success('Tạo sản phẩm giảm giá thành công');
            return redirect()->route('shop.product.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
