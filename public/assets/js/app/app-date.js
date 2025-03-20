let time = $(".flatpickr-rangepicker-single");
time.flatpickr({
    monthSelectorType: "static",
    dateFormat: "d/m/Y",
    static: !0,
});

let timeRange = $(".flatpickr-rangepicker-range");
timeRange.flatpickr({
    mode: "range",
    monthSelectorType: "static",
    dateFormat: "d/m/Y",
    static: !0,
});

let dateTime = $(".flatpickr-datetime");
dateTime.flatpickr({
    enableTime: !0,
    dateFormat: "d/m/Y H:i",
    static: !0,
});
