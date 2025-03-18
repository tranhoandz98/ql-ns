let time = $(".bs-rangepicker-single");
time.flatpickr({
    monthSelectorType: "static",
    dateFormat: "d/m/Y",
    static: !0,
});

let timeRange = $(".bs-rangepicker-range");
timeRange.flatpickr({
    mode: "range",
    monthSelectorType: "static",
    dateFormat: "d/m/Y",
    static: !0,
});
