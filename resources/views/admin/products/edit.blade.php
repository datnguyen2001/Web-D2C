@extends('admin.layout.index')
<style>
    .category:nth-child(2n) {
        background: #33333330;
    }

    #cke_1_contents {
        height: 250px !important;
    }

    .image-uploader {
        min-height: 200px;
        border: 1px solid #d9d9d9;
        position: relative
    }

    .image-uploader:hover {
        cursor: pointer
    }

    .image-uploader.drag-over {
        background-color: #f3f3f3
    }

    .image-uploader input[type=file] {
        width: 0;
        height: 0;
        position: absolute;
        z-index: -1;
        opacity: 0
    }

    .image-uploader .upload-text {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column
    }

    .image-uploader .upload-text i {
        display: block;
        font-size: 3rem;
        margin-bottom: .5rem
    }

    .image-uploader .upload-text span {
        display: block
    }

    .image-uploader.has-files .upload-text {
        display: none
    }

    .image-uploader .uploaded {
        padding: .5rem;
        line-height: 0
    }

    .image-uploader .uploaded .uploaded-image {
        display: inline-block;
        width: calc(16.6666667% - 1rem);
        padding-bottom: calc(16.6666667% - 1rem);
        height: 0;
        position: relative;
        margin: .5rem;
        background: #f3f3f3;
        cursor: default
    }

    .image-uploader .uploaded .uploaded-images {
        display: inline-block;
        width: calc(16.6666667% - 1rem);
        padding-bottom: calc(16.6666667% - 1rem);
        height: 0;
        position: relative;
        margin: .5rem;
        background: #f3f3f3;
        cursor: default
    }

    .image-uploader .uploaded .uploaded-images img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute
    }

    .image-uploader .uploaded .uploaded-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute
    }

    .image-uploader .uploaded .uploaded-image .delete-image {
        display: none;
        cursor: pointer;
        position: absolute;
        top: .2rem;
        right: .2rem;
        border-radius: 50%;
        padding: .3rem;
        background-color: rgba(0, 0, 0, .5);
        -webkit-appearance: none;
        border: none
    }

    .image-uploader .uploaded .uploaded-images .delete__image {
        display: block;
        cursor: pointer;
        position: absolute;
        top: .2rem;
        right: .2rem;
        border-radius: 50%;
        padding: .3rem;
        background-color: rgba(0, 0, 0, .5);
        border: none
    }

    .image-uploader .uploaded .uploaded-image:hover .delete-image {
        display: block
    }

    .image-uploader .uploaded .uploaded-image .delete-image i {
        color: #fff;
        font-size: 1.4rem
    }

    .image-uploader .uploaded .uploaded-images .delete__image i {
        color: #fff;
        font-size: 1.4rem
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background: #ddd;
    }

    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    ul li {
        list-style-type: none;
    }

    .sku_variant {
        text-transform: uppercase;
        text-align: center;
    }

    .sku_variant::placeholder {
        text-transform: capitalize;
    }

    .attribute_product .title-attribute:before {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background: #ffffff;
    }

    .attribute_product .title-attribute {
        padding-right: 15px;
        margin-right: 15px;
    }

    .switch_2 {
        position: relative;
        display: inline-block;
        width: 53px;
        height: 26px;
        margin: 0;
    }

    .switch_2 input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider_2 {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #B7B9BD;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider_2:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider_2 {
        background-color: #1FEB58;
    }

    input:focus + .slider_2 {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider_2:before {
        -webkit-transform: translateX(24px);
        -ms-transform: translateX(24px);
        transform: translateX(24px);
    }

    /* Rounded sliders */
    .slider_2.round_2 {
        border-radius: 34px;
    }

    .slider_2.round_2:before {
        border-radius: 50%;
    }

    .parent_category.active {
        background: #EFEFEF;
    }

    .parent_category.active img {
        display: block;
    }

    .parent_category img {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                        <div class="row mb-3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0">Tên sản phẩm :</p>
                            </div>
                            <div class="col-9">
                                <div class="row m-0 border">
                                    <input class="form-control" name="name" disabled
                                           value="{{$data->name}}">
                                </div>
                            </div>
                        </div>
                    <div class="row mb-3">
                        <div class="col-3 d-flex align-items-center">
                            <p class="m-0">Mã sản phẩm :</p>
                        </div>
                        <div class="col-9">
                            <div class="row m-0 border">
                                <input class="form-control" name="sku" disabled
                                       value="{{$data->sku}}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 box_parameter_4">
                        <div class="col-3 d-flex align-items-center">
                            <p class="m-0 parameter_4">Danh mục :</p>
                        </div>
                        <div class="col-9">
                            <input class="form-control" name="category" disabled
                                   value="{{$data->category_name}}">
                        </div>
                    </div>
                        <div class="row mb-3 box_parameter_1">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_1">Đơn vị :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="unit" disabled
                                       value="{{$data->unit}}">
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Thống tin liên hệ :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="contact_info" disabled
                                       value="{{$data->contact_info}}">
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_3">Số lượng bán tối thiểu :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="quantity" disabled
                                       value="{{$data->minimum_quantity}}">
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_3">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_3">Kho :</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="quantity" disabled
                                       value="{{$data->quantity}}">
                            </div>
                        </div>
                    <div class="card mb-5">
                        <div class="card-header bg-info text-white">
                            Hình ảnh sản phẩm
                        </div>
                        <div class="card-body">
                            <div class="image-uploader image_product has-files mt-2">
                                <div class="uploaded">
                                    @foreach($data->src as $value)
                                        <div class="uploaded-images">
                                            <img src="{{asset($value)}}" style="object-fit: cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card mb-3">
                            <a href="#collapseExample3" class="btn bg-info text-white card-header">
                                <p class="d-flex align-items-center justify-content-between mb-0"><strong
                                        style="font-weight: unset">Mô tả sản phẩm</strong><i
                                        class="fa fa-angle-down"></i></p>
                            </a>
                            <div class="card">
                                <div class="card-body mt-2">
                                    <textarea name="describe" id="content" rows="10" disabled style="width: 100%">{!! $data->describe !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                Giá sản phẩm
                            </div>
                            <div class="card-body p-2">
                                @foreach($product_attribute as $k => $value)
                                <div class="row m-0">
                                    <div class="col-lg-6 p-1">
                                        <lable>Số lượng sản phẩm</lable>
                                        <input type="text" name=""
                                               class="form-control color" placeholder="Số lượng sản phẩm"
                                               disabled value="{{$value->quantity}}">
                                    </div>
                                    <div class="col-lg-6 p-1">
                                        <lable>Giá sản phẩm</lable>
                                        <input type="text" disabled
                                               class="form-control price format-currency"
                                               value="{{number_format($value->price)}} VNĐ"
                                               placeholder="Gía sản phẩm">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label">Trạng thái sản phẩm: </label>
                            <div class="col-sm-10 d-flex flex-column justify-content-center">
                                @if($data->display == 1)
                                    <span style="color: green">Hiện</span>
                                @else
                                    <span style="color:red;">Ẩn</span>
                                @endif
                            </div>
                        </div>

                    <h8 class="card-title" style="color: #f26522">Thông tin Shop</h8>
                    <br>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Họ và tên</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" disabled class="form-control"
                                   value="{{$shop->name}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-3 col-form-label">Số điện thoại</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" id="phone" disabled class="form-control"
                                   value="{{$shop->phone}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Địa chỉ</label>
                        <div class="col-sm-9">
                            <input type="text" name="email" id="email" disabled class="form-control"
                                   value="{{$shop->full_address}}">
                        </div>
                    </div>

                        <div class="d-flex justify-content-center mt-3">
                            @if($data->status == 0)
                            <a href="{{url('admin/products/status/1/'.$data->id)}}" type="reset" class="btn btn-success">Duyệt sản phẩm</a>
                                @else
                                <a href="{{url('admin/products/status/1/'.$data->id)}}" type="reset" class="btn btn-success">Khóa sản phẩm</a>
                            @endif
                        </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')

@endsection
