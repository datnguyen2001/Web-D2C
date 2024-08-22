@extends('admin.layout.index')
@section('main')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" >
                        <div class="card-body d-flex justify-content-end" style="padding: 20px">
                            <form class="d-flex align-items-center w-50" method="get"
                                  action="{{url('admin/get-user')}}">
                                <input name="search" type="text" value="{{request()->get('search')}}"
                                       placeholder="Tìm kiếm theo tên hoặc sđt" class="form-control" style="margin-right: 16px">
                                <button class="btn btn-info" style="margin-left: 15px"><i class="bi bi-search"></i>
                                </button>
                                <a href="{{url('admin/get-user')}}" class="btn btn-danger"
                                   style="margin-left: 15px">Hủy </a>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{$titlePage}}</h5>
                            </div>
                            @if(count($listData) > 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Thông tin liên hệ</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">...</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listData as $k => $value)
                                        <tr>
                                            <th id="{{$value->id}}" scope="row">{{$k+1}}</th>
                                            <td>
                                                {{$value->name}}
                                            </td>
                                            <td>
                                                SĐT: {{$value->phone}}<br>
                                                Email: {{$value->email}}
                                            </td>

                                            <td>
                                                {{$value->full_address}}
                                            </td>
                                            <td>
                                                @if($value->display == 1)
                                                    Hoạt động
                                                @else
                                                    Bị Khóa
                                                @endif
                                            </td>
                                            <td style="border-top: 1px solid #cccccc">
                                                @if($value->display == 1)
                                                    <a href="{{url('admin/set-display-user/'.$value->id.'/0')}}">
                                                        <button type="submit" class="btn btn-danger">Khóa
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{url('admin/set-display-user/'.$value->id.'/1')}}">
                                                        <button type="submit" class="btn btn-primary">Mở khóa
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $listData->appends(request()->all())->links('admin.pagination_custom.index') }}
                                </div>
                            @else
                                <h5 class="card-title">Không có dữ liệu</h5>
                            @endif
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
            content: 'Bạn có chắc chắn muốn xóa bản ghi này?',
            buttons: {
                ok: {
                    text: 'Xóa',
                    btnClass: 'btn-danger',
                    action: function () {
                        location.href = this.$target.attr('href');
                    }
                },
                close: {
                    text: 'Hủy',
                    action: function () {
                    }
                }
            }
        });
    </script>
@endsection
