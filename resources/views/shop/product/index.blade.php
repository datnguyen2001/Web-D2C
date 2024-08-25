@extends('shop.layout.index')
<style>
    .content__product:nth-child(2n) {
        background: #E0E0E0;
    }
</style>
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Danh sách sản phẩm</h5>
                                <div>
                                    <a class="btn btn-success" href="{{route('shop.product.create')}}">Thêm sản phẩm</a>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="overflow-auto">
                                    @if(count($listData) > 0)
                                        <div>
                                            <div class="d-flex w-100 align-items-center text-center text-white font-size-16" style="background: #4154f1;padding: 5px 0">
                                                <div style="width: 15%">Mã sản phẩm</div>
                                                <div style="width: 15%">Hình ảnh</div>
                                                <div style="width: 35%">Tên sản phẩm </div>
                                                <div style="width: 15%">Danh mục </div>
                                                <div style="width: 15%">Giá gốc</div>
                                                <div style="width: 10%">Trạng thái</div>
                                                <div style="width: 10%">Thao tác </div>
                                            </div>
                                            <div class="w-100 bg-white mt-10">
                                                @foreach($listData as $item)
                                                    <div class="w-100 d-flex mb-2 pt-2 pb-2 content__product align-items-center">
                                                        <div style="width: 15%" class="d-flex justify-content-center">
                                                            <p>{{$item->sku}}</p>
                                                        </div>
                                                        <div style="width: 15%" class="d-flex justify-content-center">
                                                            <img src="{{asset(@$item->src[0])}}" alt="" class="w-75 mr-3" style="border-radius: 4px">
                                                        </div>
                                                        <div style="width: 35%" class="d-flex justify-content-center flex-column align-items-center">
                                                            <p class="mb-1">{{$item->name}}</p>
                                                            <p class="mb-1">Số lượng: {{ $item->quantity }}</p>
                                                            <p class="mb-1">{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</p>
                                                        </div>
                                                        <div style="width: 15%" class="d-flex justify-content-center">
                                                            <p>{{$item->category_name}}</p>
                                                        </div>
                                                        <div style="width: 15%" class="d-flex justify-content-center">
                                                            <p>{{number_format($item->price)}} vnđ</p>
                                                        </div>
                                                        <div style="width: 10%" class="d-flex justify-content-center">
                                                            <p>Hiện</p>
                                                        </div>
                                                        <div style="width: 10%" class="d-flex justify-content-center flex-wrap">
                                                            <div class="btn-group">
                                                                <a href="{{url('shop/product/edit/'.$item->id)}}" class="btn btn-icon btn-light btn-hover-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Cập nhật">
                                                                    <i class="bi bi-pencil-square "></i>
                                                                </a>
                                                                <a href="{{url('shop/product/delete/'.$item->id)}}" class="btn btn-delete btn-icon btn-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Xóa">
                                                                    <i class="bi bi-trash "></i>
                                                                </a>
                                                            </div>
                                                            <a href="{{url('shop/product/discount/'.$item->id)}}" class="btn btn-danger" style="font-size: 14px;padding: 5px;margin-top: 7px">Giảm giá</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {{ $listData->appends(request()->all())->links('shop.pagination_custom.index') }}
                                        </div>
                                    @else
                                        <h5 class="card-title">Không có dữ liệu</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        $('a.btn-delete').confirm({
            title: 'Xác nhận!',
            content: 'Bạn có chắc chắn muốn xóa bản ghi này?, Xóa sản phẩm này thì các đơn hàng có sản phẩm này cũng bị xóa? Bạn có muốn xóa không.',
            buttons: {
                ok: {
                    text: 'Xóa',
                    btnClass: 'btn-danger',
                    action: function(){
                        location.href = this.$target.attr('href');
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {}
                }
            }
        });
    </script>
@endsection
