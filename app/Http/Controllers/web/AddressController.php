<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\DistrictModel;
use App\Models\ProvinceModel;
use App\Models\WardsModel;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function province(){
        try{
            $data = ProvinceModel::all();
            return response()->json(['message'=>'Lấy thông tin thành công','data'=>$data,'status'=>true]);
        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }

    public function district($province_id){
        try{
            $data = DistrictModel::where('province_id',$province_id)->get();
            return response()->json(['message'=>'Lấy thông tin thành công','data'=>$data,'status'=>true]);
        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }

    public function wards($district_id){
        try{
            $data = WardsModel::where('district_id',$district_id)->get();
            return response()->json(['message'=>'Lấy thông tin thành công','data'=>$data,'status'=>true]);
        }catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>false]);
        }
    }
}
