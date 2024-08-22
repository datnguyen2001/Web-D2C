<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DistrictModel;
use App\Models\ProvinceModel;
use App\Models\RequestSupplierModel;
use App\Models\ShopModel;
use App\Models\User;
use App\Models\WardsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestSupplierController extends Controller
{
    public function approvedNot(Request $request)
    {
        $titlePage = 'Danh sách yêu cầu chưa duyệt';
        $page_menu = 'request';
        $page_sub = 'not_yet_approved';
        $search = $request->input('key_search');
        $query = RequestSupplierModel::where('status', 0);
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $listData = $query->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $val){
            $val->src = json_decode($val->src, true);
            $val->user = User::find($val->user_id);
        }

        return view('admin.request.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function approved(Request $request)
    {
        $titlePage = 'Danh sách yêu cầu đã duyệt';
        $page_menu = 'request';
        $page_sub = 'approved';
        $search = $request->input('key_search');
        $query = RequestSupplierModel::where('status', 1);
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $listData = $query->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $val){
            $val->src = json_decode($val->src, true);
            $val->user = User::find($val->user_id);
        }

        return view('admin.request.approved', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function detail($id)
    {
        try {
            $titlePage = 'Chi tiết yêu cầu';
            $page_menu = 'request';
            $page_sub = null;
            $data = RequestSupplierModel::find($id);
            $data->src = json_decode($data->src, true);
            $data->scope_name = ProvinceModel::where('province_id',$data->scope)->first()->name;
            $user = User::find($data->user_id);
            $province = ProvinceModel::where('province_id', $user->province_id)->first();
            $district = DistrictModel::where('district_id', $user->district_id)->first();
            $ward = WardsModel::where('wards_id', $user->ward_id)->first();
            $user->full_address = $user->address_detail . ', ' . $ward->name . ', ' . $district->name . ', ' . $province->name;

            return view('admin.request.edit', compact('titlePage', 'page_menu', 'page_sub','data','user'));
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function status($status,$id)
    {
        try {
            $data = RequestSupplierModel::find($id);
            $data->status = $status;
            $data->save();
            toastr()->success('Cập nhật trạng thái yêu cầu thành công');
            return back();
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $data = RequestSupplierModel::find($id);
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
