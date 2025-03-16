class m extends Notyf {
    _renderNotification(e) {
        var t = super._renderNotification(e);
        return e.message && (t.message.innerHTML = e.message), t;
    }
}
let p = new m({
    duration: 3e3,
    ripple: !0,
    dismissible: !1,
    position: {
        x: "right",
        y: "top"
    },
    types: [{
            type: "info",
            background: config.colors.info,
            className: "notyf__info",
            icon: {
                className: "icon-base ti tabler-info-circle-filled icon-md text-white",
                tagName: "i",
            },
        },
        {
            type: "warning",
            background: config.colors.warning,
            className: "notyf__warning",
            icon: {
                className: "icon-base ti tabler-alert-triangle-filled icon-md text-white",
                tagName: "i",
            },
        },
        {
            type: "success",
            background: config.colors.success,
            className: "notyf__success",
            icon: {
                className: "icon-base ti tabler-circle-check-filled icon-md text-white",
                tagName: "i",
            },
        },
        {
            type: "error",
            background: config.colors.danger,
            className: "notyf__error",
            icon: {
                className: "icon-base ti tabler-xbox-x-filled icon-md text-white",
                tagName: "i",
            },
        },
    ],
});

function showAlert(type = 'success', message = '') {
    o = {
        type: type,
        message: message,
        duration: 3000,
        dismissible: false,
        ripple: true,
        position: {
            x: 'right',
            y: 'top',
        },
    };
    p.open(o);
}
