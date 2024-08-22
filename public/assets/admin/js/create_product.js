$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // add thuoc tinh
    $(document).on("click", ".btn-add-attribute", function () {
        let parent = $(this).closest(".data-variant");
        let list_size = parent.find(".list-size");
        let data = {};
        data["count"] = list_size.children().length;
        data["index"] = parent.index();
        $.ajax({
            url: window.location.origin + "/admin/attribute-name",
            type: "post",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                list_size.append(data.html);
            },
        });
    });
    // delete loai thuoc tinh
    $(document).on("click", ".btn-clear-size", function () {
        let data_parent = $(this).closest(".data-variant");
        let parents = $(this).closest(".row");
        parents.remove();
        let index = data_parent.index();
        let list_size = data_parent.find(".list-size");
        let count = list_size.children().length;
        for (let i = 0; i < count; i++) {
            let name = "variant[" + index + "][data][" + i + "][name]";
            let current_stock =
                "variant[" + index + "][data][" + i + "][current_stock]";
            let cost = "variant[" + index + "][data][" + i + "][cost]";
            let price = "variant[" + index + "][data][" + i + "][price]";
            list_size
                .children()
                .eq(i)
                .find(".form-control.name_attribute")
                .attr("name", name);
            list_size
                .children()
                .eq(i)
                .find(".form-control.current_stock")
                .attr("name", current_stock);
            list_size
                .children()
                .eq(i)
                .find(".form-control.cost")
                .attr("name", cost);
            list_size
                .children()
                .eq(i)
                .find(".form-control.price")
                .attr("name", price);
        }
    });
    // add ten thuoc tinh
    $(document).on("click", ".btn-add-type-attribute", function () {
        let parent = $(this).closest(".card-body");
        $.ajax({
            url: window.location.origin + "/admin/attribute-type",
            type: "post",
            data: { count: parent.children().length },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                parent.append(data.html);
            },
        });
    });
    // delete ten thuoc tinh
    $(document).on("click", ".btn-clear-color", function () {
        let parents = $(this).closest(".data-variant");
        parents.remove();
        let index = $(".card-body .data-variant").length;
        for (let i = 0; i < index; i++) {
            let name = "variant[" + i + "][name]";
            let select = $(".data-variant").eq(i).find(".form-control.name");
            select.attr("name", name);
            let list_size = $(".data-variant").eq(i).find(".list-size");
            let count = list_size.children().length;
            for (let j = 0; j < count; j++) {
                let name = "variant[" + i + "][data][" + j + "][name]";
                let current_stock =
                    "variant[" + i + "][data][" + j + "][current_stock]";
                let cost = "variant[" + i + "][data][" + j + "][cost]";
                let price = "variant[" + i + "][data][" + j + "][price]";
                list_size
                    .children()
                    .eq(j)
                    .find(".form-control.name_attribute")
                    .attr("name", name);
                list_size
                    .children()
                    .eq(j)
                    .find(".form-control.current_stock")
                    .attr("name", current_stock);
                list_size
                    .children()
                    .eq(j)
                    .find(".form-control.cost")
                    .attr("name", cost);
                list_size
                    .children()
                    .eq(j)
                    .find(".form-control.price")
                    .attr("name", price);
            }
        }
    });
});
