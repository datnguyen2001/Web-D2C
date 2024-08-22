<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TrademarkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrademarkController extends Controller
{
    public function index()
    {
        $titlePage = 'Danh sách thương hiệu';
        $page_menu = 'trademark';
        $page_sub = null;
        $listData = TrademarkModel::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.trademark.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function create ()
    {
        try{
            $titlePage = 'Thêm thương hiệu';
            $page_menu = 'trademark';
            $page_sub = null;
            return view('admin.trademark.create', compact('titlePage', 'page_menu', 'page_sub'));
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store (Request $request)
    {
        try{
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('trademark', 'public'));
            }else{
                return back()->with(['info'=>'Vui lòng thêm ảnh để tiếp tục']);
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $trademark = new TrademarkModel([
                'src' => $imagePath,
                'display' => $display,
            ]);
            $trademark->save();
            return redirect()->route('admin.trademark.index')->with(['success' => 'Tạo thương hiệu thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete ($id)
    {
        $trademark = TrademarkModel::find($id);
        if (isset($trademark->src) && Storage::exists(str_replace('/storage', 'public', $trademark->src))) {
            Storage::delete(str_replace('/storage', 'public', $trademark->src));
        }
        $trademark->delete();
        return redirect()->route('admin.trademark.index')->with(['success'=>"Xóa dữ liệu thành công"]);
    }

    public function edit ($id)
    {
        try{
            $trademark = TrademarkModel::find($id);
            if (empty($trademark)) {
                return back()->with(['error' => 'Thương hiệu không tồn tại']);
            }
            $titlePage = 'Sửa thương hiệu';
            $page_menu = 'trademark';
            $page_sub = null;
            return view('admin.trademark.edit', compact('titlePage', 'page_menu', 'page_sub', 'trademark'));
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $trademark = TrademarkModel::find($id);
            if (empty($trademark)){
                return back()->with(['error' => 'Thương hiệu không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('trademark', 'public'));
                if (isset($trademark->src) && Storage::exists(str_replace('/storage', 'public', $trademark->src))) {
                    Storage::delete(str_replace('/storage', 'public', $trademark->src));
                }
                $trademark->src = $imagePath;
            }
            if ($request->get('display') == 'on'){
                $display = 1;
            }else{
                $display = 0;
            }
            $trademark->display = $display;
            $trademark->save();
            return redirect()->route('admin.trademark.index')->with(['success' => 'Cập nhật thương hiệu thành công']);
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
