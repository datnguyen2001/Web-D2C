<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\DistrictModel;
use App\Models\ProductsAttributeModel;
use App\Models\ProductsModel;
use App\Models\ProvinceModel;
use App\Models\ShopModel;
use App\Models\WardsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function approvedNot(Request $request)
    {
        $titlePage = 'Danh sách sản phẩm chưa duyệt';
        $page_menu = 'product';
        $page_sub = 'not_yet_approved';
        $search = $request->input('key_search');
        $query = ProductsModel::where('status', 0);
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }
        $listData = $query->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $val){
            $val->src = json_decode($val->src, true);
            $val->category_name = CategoryModel::find($val->category_id)->name;
            $val->shop = ShopModel::find($val->shop_id);
        }

        return view('admin.products.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function approved(Request $request)
    {
        $titlePage = 'Danh sách sản phẩm đã duyệt';
        $page_menu = 'product';
        $page_sub = 'approved';
        $search = $request->input('key_search');
        $query = ProductsModel::where('status', 1);
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }
        $listData = $query->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $val){
            $val->src = json_decode($val->src, true);
            $val->category_name = CategoryModel::find($val->category_id)->name;
            $val->shop = ShopModel::find($val->shop_id);
        }

        return view('admin.products.approved', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function detail($id)
    {
        try {
            $titlePage = 'Chi tiết sản phẩm';
            $page_menu = 'product';
            $page_sub = null;
            $data = ProductsModel::find($id);
            $data->src = json_decode($data->src, true);
            $data->category_name = CategoryModel::find($data->category_id)->name;
            $product_attribute = ProductsAttributeModel::where('product_id',$id)->get();
            $shop = ShopModel::find($data->shop_id);
            $province = ProvinceModel::where('province_id', $shop->province_id)->first();
            $district = DistrictModel::where('district_id', $shop->district_id)->first();
            $ward = WardsModel::where('wards_id', $shop->ward_id)->first();
            $shop->full_address = $shop->address_detail . ', ' . $ward->name . ', ' . $district->name . ', ' . $province->name;


            return view('admin.products.edit', compact('titlePage', 'page_menu', 'page_sub','data','product_attribute','shop'));
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function status($status,$id)
    {
        try {
            $data = ProductsModel::find($id);
            $data->status = $status;
            $data->save();
            toastr()->success('Cập nhật trạng thái sản phẩm thành công');
            return back();
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
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

}
