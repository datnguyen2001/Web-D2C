<div class="mt-3 border-bottom data-variant pb-3">
    <div class="row m-0">
        <div class="col-lg-3 p-1">
            <input type="text" name="variant[{{$count}}][name]" class="form-control name" placeholder="Mua từ"
                   required>
        </div>
        <div class="col-lg-3 p-1">
            <input type="text" name="variant[{{$count}}][price]" class="form-control price format-currency"
                   placeholder="Giá bán" required>
        </div>
        <div class="col-lg-2 p-1">
            <button type="button" class="btn btn-success btn-add-color form-control"><i class="bi bi-plus-lg"></i> Thêm
                Giá
            </button>
        </div>
        <div class="col-lg-2 p-1">
            <button type="button" class="btn btn-danger btn-clear-color">
                <i class="bi bi-trash"></i> Xóa
            </button>
        </div>
    </div>
</div>
