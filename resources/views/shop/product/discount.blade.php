@extends('shop.layout.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{url('shop/product/update-discount/'.$id)}}" enctype="multipart/form-data"
                          class="card p-3">
                        @csrf
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Ngày bắt đầu</p>
                            </div>
                            <div class="col-9">
                                <input type="date" class="form-control" name="date_start" value="{{@$product->date_start}}" required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Ngày kết thúc</p>
                            </div>
                            <div class="col-9">
                                <input type="date" class="form-control" name="date_end" value="{{@$product->date_end}}" required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Số lượng áp dụng giảm giá</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="number" value="{{@$product->number}}" required>
                            </div>
                        </div>
                        <div class="row mb-3 box_parameter_2">
                            <div class="col-3 d-flex align-items-center">
                                <p class="m-0 parameter_2">Phần trăm giảm giá</p>
                            </div>
                            <div class="col-9">
                                <input class="form-control" name="discount" value="{{@$product->discount}}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success" style="margin-right: 15px">Lưu</button>
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
@endsection
