!function (e) {
    e.fn.imageUploader = function (t) {
        let n = {
            preloaded: [],
            imagesInputName: "images",
            preloadedInputName: "preloaded",
            label: "Chọn hoặc kéo thả ảnh"
        }, i = this;
        i.settings = {}, i.init = function () {
            i.settings = e.extend(i.settings, n, t), i.each(function (t, n) {
                let o = a();
                if (e(n).append(o), o.on("dragover", l.bind(o)), o.on("dragleave", l.bind(o)), o.on("drop", s.bind(o)), i.settings.preloaded.length) {
                    o.addClass("has-files");
                    let e = o.find(".uploaded");
                    for (let t = 0; t < i.settings.preloaded.length; t++) e.append(d(i.settings.preloaded[t].src, i.settings.preloaded[t].id, !0))
                }
            })
        };
        let o = new DataTransfer, a = function () {
            let t = e("<div>", {class: "image-uploader"}), n = e("<input>", {
                    type: "file",
                    id: i.settings.imagesInputName + "-" + p(),
                    name: i.settings.imagesInputName + "[]",
                    multiple: ""
                }).appendTo(t),
                o = (e("<div>", {class: "uploaded"}).appendTo(t), e("<div>", {class: "upload-text"}).appendTo(t));
            return e("<i>", {
                class: "fa fa-upload",
                //text: "cloud_upload"
            }).appendTo(o), e("<span>", {text: i.settings.label}).appendTo(o), t.on("click", function (e) {
                r(e), n.trigger("click")
            }), n.on("click", function (e) {
                e.stopPropagation()
            }), n.on("change", s.bind(t)), t
        }, r = function (e) {
            e.preventDefault(), e.stopPropagation()
        }, d = function (t, n) {
            let a = e("<div>", {class: "uploaded-image"}),
                d = (e("<img>", {src: t}).appendTo(a), e("<button>", {class: "delete-image"}).appendTo(a));
            return e("<i>", {
                class: "bi bi-x",
                text: ""
            }).appendTo(d), i.settings.preloaded.length ? (a.attr("data-preloaded", !0), e("<input>", {
                type: "hidden",
                name: i.settings.preloadedInputName + "[]",
                value: n
            }).appendTo(a)) : a.attr("data-index", n), a.on("click", function (e) {
                r(e)
            }), d.on("click", function (t) {
                if (r(t), a.data("index")) {
                    let t = parseInt(a.data("index"));
                    a.find(".uploaded-image[data-index]").each(function (n, i) {
                        n > t && e(i).attr("data-index", n - 1)
                    }), o.items.remove(t)
                }
                a.remove(), a.find(".uploaded-image").length || a.removeClass("has-files")
            }), a
        }, l = function (t) {
            r(t), "dragover" === t.type ? e(this).addClass("drag-over") : e(this).removeClass("drag-over")
        }, s = function (t) {
            r(t);
            let n = e(this);
            n.removeClass("drag-over");
            let i = t.target.files || t.originalEvent.dataTransfer.files;
            u(n, i)
        }, u = function (t, n) {
            t.addClass("has-files");
            let i = t.find(".uploaded"), a = t.find('input[type="file"]');
            e(n).each(function (e, t) {
                o.items.add(t), i.append(d(URL.createObjectURL(t), o.items.length - 1))
            }), a.prop("files", o.files)
        }, p = function () {
            return Date.now() + Math.floor(100 * Math.random() + 1)
        };
        return this.init(), this
    }
}(jQuery), $(".input-image-product").imageUploader(), function (e) {
    var t = {};

    function n(i) {
        if (t[i]) return t[i].exports;
        var o = t[i] = {i: i, l: !1, exports: {}};
        return e[i].call(o.exports, o, o.exports, n), o.l = !0, o.exports
    }

    n.m = e, n.c = t, n.d = function (e, t, i) {
        n.o(e, t) || Object.defineProperty(e, t, {enumerable: !0, get: i})
    }, n.r = function (e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
    }, n.t = function (e, t) {
        if (1 & t && (e = n(e)), 8 & t) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var i = Object.create(null);
        if (n.r(i), Object.defineProperty(i, "default", {
            enumerable: !0,
            value: e
        }), 2 & t && "string" != typeof e) for (var o in e) n.d(i, o, function (t) {
            return e[t]
        }.bind(null, o));
        return i
    }, n.n = function (e) {
        var t = e && e.__esModule ? function () {
            return e.default
        } : function () {
            return e
        };
        return n.d(t, "a", t), t
    }, n.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, n.p = "/", n(n.s = 32)
}({
    32: function (e, t, n) {
        e.exports = n(33)
    }, 33: function (e, t) {
        $(document).ready(function () {
            "use strict";
            $(".repeater").repeater({
                defaultValues: {
                    "textarea-input": "foo",
                    "text-input": "bar",
                    "select-input": "B",
                    "checkbox-input": ["A", "B"],
                    "radio-input": "B"
                }, show: function () {
                    $(this).slideDown()
                }, hide: function (e) {
                    confirm("Bạn có chắc chắn muốn xóa thuộc tính?") && $(this).slideUp(e)
                }, ready: function (e) {
                }
            }), window.outerRepeater = $(".outer-repeater").repeater({
                defaultValues: {"text-input": "outer-default"},
                show: function () {
                    console.log("outer show"), $(this).slideDown()
                },
                hide: function (e) {
                    console.log("outer delete"), $(this).slideUp(e)
                },
                repeaters: [{
                    selector: ".inner-repeater",
                    defaultValues: {"inner-text-input": "inner-default"},
                    show: function () {
                        console.log("inner show"), $(this).slideDown()
                    },
                    hide: function (e) {
                        console.log("inner delete"), $(this).slideUp(e)
                    }
                }]
            })
        })
    }
});
