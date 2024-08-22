<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $titlePage = 'Danh sách banner';
        $page_menu = 'banner';
        $page_sub = null;
        $listData = BannerModel::orderBy('ordinal_number', 'asc')->paginate(10);

        return view('admin.banner.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function create ()
    {
        try{
            $titlePage = 'Thêm banner';
            $page_menu = 'banner';
            $page_sub = null;
            return view('admin.banner.create', compact('titlePage', 'page_menu', 'page_sub'));
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store (Request $request)
    {
        try{
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('banner', 'public'));
            }else{
                return back()->with(['info'=>'Vui lòng thêm ảnh để tiếp tục']);
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $banner = new BannerModel([
                'src' => $imagePath,
                'display' => $display,
                'link' => $request->get('link'),
                'ordinal_number' => $request->get('ordinal_number'),
                'location' => $request->get('location'),
            ]);
            $banner->save();
            return redirect()->route('admin.banner.index')->with(['success' => 'Tạo banner thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete ($id)
    {
        $banner = BannerModel::find($id);
        if (isset($banner->src) && Storage::exists(str_replace('/storage', 'public', $banner->src))) {
            Storage::delete(str_replace('/storage', 'public', $banner->src));
        }
        $banner->delete();
        return redirect()->route('admin.banner.index')->with(['success'=>"Xóa dữ liệu thành công"]);
    }

    public function edit ($id)
    {
        try{
            $banner = BannerModel::find($id);
            if (empty($banner)) {
                return back()->with(['error' => 'Banner không tồn tại']);
            }
            $titlePage = 'Sửa banner';
            $page_menu = 'banner';
            $page_sub = null;
            return view('admin.banner.edit', compact('titlePage', 'page_menu', 'page_sub', 'banner'));
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $banner = BannerModel::find($id);
            if (empty($banner)){
                return back()->with(['error' => 'Banner không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('banner', 'public'));
                if (isset($banner->src) && Storage::exists(str_replace('/storage', 'public', $banner->src))) {
                    Storage::delete(str_replace('/storage', 'public', $banner->src));
                }
                $banner->src = $imagePath;
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $banner->link = $request->get('link');
            $banner->ordinal_number = $request->get('ordinal_number');
            $banner->location = $request->get('location');
            $banner->display = $display;
            $banner->save();
            return redirect()->route('admin.banner.index')->with(['success' => 'Cập nhật banner thành công']);
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
