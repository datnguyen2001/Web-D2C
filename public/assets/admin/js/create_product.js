$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".selector__image").click(function () {
        $('input[name="file_product"]').trigger("click");
    });
    $('input[name="file_product"]').change(function () {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                if (input.files[0].type == 'video/mp4') {
                    let video = '<video class="w-100 h-100" style="object-fit: cover;"><source src=" ' + e.target.result + ' " type="' + input.files[0].type + '"></video>';
                    $(".selector__image").html(video);
                } else {
                    let img = '<img src="' + e.target.result + '" class="w-100 h-100" style="object-fit: cover;">';
                    $(".selector__image").html(img);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    let isLoading = false;
    $(document).on("click", ".btn-add-color", function () {
        let parent = $(this).closest(".card-body-color");
        if (isLoading) return;
        isLoading = true;
        $.ajax({
            url: window.location.origin + '/shop/product/variant-price',
            type: 'post',
            data: {"count": parent.children().length},
            dataType: 'json',
            success: function (data) {
                parent.append(data.html);
            },
            complete: function() {
                isLoading = false;
            }
        });
    });
    // delete color
    $(document).on("click", ".btn-clear-color", function () {
        let parents = $(this).closest(".data-variant");
        parents.remove();
        let index = $(".card-body .data-variant").length;
        for (let i = 0; i < index; i++) {
            let name = 'variant[' + i + '][name]';
            let select = $(".data-variant").eq(i).find(".form-control.name");
            select.attr("name", name);
            let src = 'variant[' + i + '][price]';
            let select_src = $(".data-variant").eq(i).find(".form-control.price");
            select_src.attr("name", src);
        }
    });
});
