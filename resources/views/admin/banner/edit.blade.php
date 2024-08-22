@extends('admin.layout.index')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Cập nhật banner</h1>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="bg-white p-4">
                <form action="{{url("admin/banner/update",$banner->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-3">Hình ảnh: </div>
                        <div class="col-8">
                            <div class="form-control position-relative div-parent" style="padding-top: 50%">
                                <div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">
                                    <button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%"><i class="bi bi-x-lg text-white"></i></button>
                                        <img src="{{asset($banner->src)}}" class="w-100 h-100" style="object-fit: cover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">Link: </div>
                        <div class="col-8">
                            <input type="number" class="form-control" name="link" value="{{@$banner->link}}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">Thứ tự hiển thị :</div>
                        <div class="col-8">
                            <input type="number" class="form-control" name="ordinal_number" value="{{@$banner->ordinal_number}}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">Vị trí :</div>
                        <div class="col-8">
                            <select name="location" class="form-control">
                                <option value="1" @if($banner->location == 1) selected @endif>Banner home top left</option>
                                <option value="2" @if($banner->location == 2) selected @endif>Banner home top right</option>
                                <option value="3" @if($banner->location == 3) selected @endif>Banner home main center</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">Bật/tắt :</div>
                        <div class="col-8">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="display" @if($banner->display == 1) checked @endif type="checkbox"
                                       id="flexSwitchCheckChecked">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Hiện </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-3"></div>
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{route('admin.banner.index')}}" class="btn btn-danger">Hủy</a>
                        </div>
                        <input type="file" name="file" accept="image/x-png,image/gif,image/jpeg" hidden>
                    </div>
                </form>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        let parent;
        $(document).on("click", ".select-image", function () {
            $('input[name="file"]').click();
            parent = $(this).parent();
        });
        $('input[name="file"]').change(function(e){
            imgPreview(this);
        });
        function imgPreview(input) {
            let file = input.files[0];
            let mixedfile = file['type'].split("/");
            let filetype = mixedfile[0]; // (image, video)
            if(filetype == "image"){
                let reader = new FileReader();
                reader.onload = function(e){
                    $("#preview-img").show().attr("src", );
                    let html = '<div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">' +
                        '<button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%"><i class="bi bi-x-lg text-white"></i></button>'+
                        '<img src="'+e.target.result+'" class="w-100 h-100" style="object-fit: cover">' +
                        '</div>';
                    parent.html(html);
                }
                reader.readAsDataURL(input.files[0]);
            }else{
                alert("Invalid file type");
            }
        }
        $(document).on("click", "button.clear", function () {
            parent = $(this).closest(".div-parent");
            $(".div-file").remove();
            let html = '<button type="button" class="position-absolute border-0 bg-transparent select-image" style="top: 50%;left: 50%;transform: translate(-50%,-50%)">\n' +
                '                                    <i style="font-size: 30px" class="bi bi-download"></i>\n' +
                '                                </button>';
            parent.html(html);
            $('input[name="file"]').val("");
        });
    </script>
@endsection
