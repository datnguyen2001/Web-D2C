@extends('shop.layout.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{route('shop.product.store')}}" enctype="multipart/form-data"
                          class="card p-3">
                        @csrf
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Tên sản phẩm</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Mã sản phẩm</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="sku" value="{{old('sku')}}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Nhóm thuốc :</p>
                            </div>
                            <div class="col-9">
                                <select name="category_id" class="form-control">
                                    @foreach($category as $key => $cate)
                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Đơn vị :</p>
                            </div>
                            <div class="col-9">
                                <select name="unit" class="form-control">
                                    <option value="Hộp">Hộp</option>
                                    <option value="Cái">Cái</option>
                                    <option value="Lốc">Lốc</option>
                                    <option value="Lọ">Lọ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Số điện thoại liên hệ</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="contact_info"
                                       required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Mua tối thiểu</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="minimum_quantity"
                                       required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Số lượng trong kho</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="quantity"
                                       required>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                Hình ảnh sản phẩm
                            </div>
                            <div class="card-body">
                                <label class="mt-2 mb-2"><i class="fa fa-upload"></i> Chọn hoặc kéo ảnh vào khung bên
                                    dưới</label>
                                <div class="input-image-product">
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <a data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="true"
                               aria-controls="collapseExample1" class="btn bg-info text-white card-header">
                                <p class="d-flex align-items-center justify-content-between mb-0"><strong
                                        style="font-weight: unset">Thông tin sản phẩm</strong><i
                                        class="fa fa-angle-down"></i></p>
                            </a>
                            <div id="collapseExample1" class="collapse shadow-sm show">
                                <div class="card">
                                    <div class="card-body mt-2">
                                        <textarea name="content" id="content"
                                                  class="ckeditor">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                Giá sản phẩm
                            </div>
                            <div class="card-body card-body-color p-0 bg-white">
                                <div class="mt-3 border-bottom data-variant pb-3">
                                    <div class="row m-0">
                                        <div class="col-lg-3 p-1">
                                            <input type="text" name="variant[0][name]" class="form-control"
                                                   placeholder="Mua từ" required>
                                        </div>
                                        <div class="col-lg-3 p-1">
                                            <input type="text" name="variant[0][price]" class="form-control format-currency"
                                                   placeholder="Giá bán" required>
                                        </div>
                                        <div class="col-lg-2 p-1">
                                            <button type="button" class="btn btn-success btn-add-color form-control"><i
                                                    class="bi bi-plus-lg"></i> Thêm Giá
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Trạng thái: </label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="display" type="checkbox" checked
                                           id="flexSwitchCheckChecked">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Hiện sản phẩm</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Tạo mới</button>
                            <a href="{{route('shop.product.index')}}" class="btn btn-dark">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="{{url('assets/admin/js/input_file.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/js/format_currency.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/js/create_product.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height: '500px'
        });
    </script>
@endsection
