document.addEventListener("DOMContentLoaded", function (e) {
    let l = document.querySelector(".start_date"),
        s = document.querySelector(".end_date"),
        o = document.querySelector(".flatpickr-range"),
        c =
            (o &&
                o.flatpickr({
                    mode: "range",
                    dateFormat: "m/d/Y",
                    orientation: isRtl ? "auto right" : "auto left",
                    locale: { format: "MM/DD/YYYY" },
                    onClose: function (e, t, a) {
                        var n;
                        new Date();
                        void 0 !== e[0] &&
                            ((n = new Date(e[0]).toLocaleDateString("en-US", {
                                month: "2-digit",
                                day: "2-digit",
                                year: "numeric",
                            })),
                            (l.value = n)),
                            void 0 !== e[1] &&
                                ((n = new Date(e[1]).toLocaleDateString(
                                    "en-US",
                                    {
                                        month: "2-digit",
                                        day: "2-digit",
                                        year: "numeric",
                                    }
                                )),
                                (s.value = n)),
                            o.dispatchEvent(new Event("change")),
                            o.dispatchEvent(new Event("keyup"));
                    },
                }),
            void 0 !== $.fn &&
                void 0 !== $.fn.dataTableExt &&
                ($.fn.dataTableExt.afnFiltering.length = 0),
            function (e) {
                e = new Date(e);
                return (
                    e.getFullYear() +
                    ("0" + (e.getMonth() + 1)).slice(-2) +
                    ("0" + e.getDate()).slice(-2)
                );
            });
    var t = document.querySelector(".datatables-ajax"),
        t =
            (t &&
                new DataTable(t, {
                    processing: !0,
                    ajax: {
                        url: assetsPath + "json/ajax.php",
                        dataSrc: "data",
                    },
                    layout: {
                        topStart: {
                            rowClass: "row mx-3 my-0 justify-content-between",
                            features: [
                                {
                                    pageLength: {
                                        menu: [7, 10, 25, 50, 100],
                                        text: "Show_MENU_entries",
                                    },
                                },
                            ],
                        },
                        topEnd: { search: { placeholder: "" } },
                        bottomStart: {
                            rowClass: "row mx-3 justify-content-between",
                            features: ["info"],
                        },
                        bottomEnd: "paging",
                    },
                    language: {
                        paginate: {
                            next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                            previous:
                                '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                            first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                            last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>',
                        },
                    },
                }),
            document.querySelector(".dt-column-search"));
    if (t) {
        var a = document.querySelector(".dt-column-search thead"),
            n = a.querySelector("tr").cloneNode(!0);
        a.appendChild(n);
        let l = a.querySelectorAll("tr:nth-child(2) th"),
            s =
                (l.forEach((e, t) => {
                    var a = e.textContent,
                        n = document.createElement("input");
                    (n.type = "text"),
                        (n.className = "form-control"),
                        (n.placeholder = "Search " + a),
                        (e.style.borderLeft = "none"),
                        t === l.length - 1 && (e.style.borderRight = "none"),
                        (e.innerHTML = ""),
                        e.appendChild(n),
                        n.addEventListener("keyup", function () {
                            s.column(t).search() !== this.value &&
                                s.column(t).search(this.value).draw();
                        }),
                        n.addEventListener("change", function () {
                            s.column(t).search() !== this.value &&
                                s.column(t).search(this.value).draw();
                        });
                }),
                new DataTable(t, {
                    ajax: assetsPath + "json/table-datatable.json",
                    columns: [
                        { data: "full_name" },
                        { data: "email" },
                        { data: "post" },
                        { data: "city" },
                        { data: "start_date" },
                        { data: "salary" },
                    ],
                    orderCellsTop: !0,
                    layout: {
                        topStart: {
                            rowClass: "row mx-3 my-0 justify-content-between",
                            features: [
                                {
                                    pageLength: {
                                        menu: [7, 10, 25, 50, 100],
                                        text: "Show_MENU_entries",
                                    },
                                },
                            ],
                        },
                        topEnd: { search: { placeholder: "Type search here" } },
                        bottomStart: {
                            rowClass: "row mx-3 justify-content-between",
                            features: ["info"],
                        },
                        bottomEnd: "paging",
                    },
                    language: {
                        paginate: {
                            next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                            previous:
                                '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                            first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                            last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>',
                        },
                    },
                }));
    }
    n = document.querySelector(".dt-advanced-search");
    let r;
    n &&
        (r = new DataTable(n, {
            ajax: assetsPath + "json/table-datatable.json",
            columns: [
                { data: "" },
                { data: "full_name" },
                { data: "email" },
                { data: "post" },
                { data: "city" },
                { data: "start_date" },
                { data: "salary" },
            ],
            columnDefs: [
                {
                    className: "control",
                    orderable: !1,
                    targets: 0,
                    render: function (e, t, a, n) {
                        return "";
                    },
                },
            ],
            layout: {
                topStart: { rowClass: "m-0", features: [] },
                topEnd: {},
                bottomStart: {
                    rowClass: "row mx-3 justify-content-between",
                    features: ["info"],
                },
                bottomEnd: "paging",
            },
            language: {
                paginate: {
                    next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                    previous:
                        '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                    first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                    last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>',
                },
            },
            orderCellsTop: !0,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (e) {
                            return "Details of " + e.data().full_name;
                        },
                    }),
                    type: "column",
                    renderer: function (e, t, a) {
                        var n,
                            l,
                            s,
                            a = a
                                .map(function (e) {
                                    return "" !== e.title
                                        ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                      <td>${e.title}:</td>
                      <td>${e.data}</td>
                    </tr>`
                                        : "";
                                })
                                .join("");
                        return (
                            !!a &&
                            ((n = document.createElement("div")).classList.add(
                                "table-responsive"
                            ),
                            (l = document.createElement("table")),
                            n.appendChild(l),
                            l.classList.add("table"),
                            ((s = document.createElement("tbody")).innerHTML =
                                a),
                            l.appendChild(s),
                            n)
                        );
                    },
                },
            },
        })),
        document.querySelectorAll("input.dt-input").forEach((e) => {
            e.addEventListener("keyup", function () {
                var e,
                    t,
                    a = this.getAttribute("data-column"),
                    n = this.value;
                (5 == a
                    ? ((e = l.value),
                      (t = s.value),
                      "" !== e &&
                          "" !== t &&
                          (($.fn.dataTable.ext.search.length = 0),
                          ((s, o, r) => {
                              void 0 !== $.fn &&
                                  void 0 !== $.fn.dataTableExt &&
                                  $.fn.dataTableExt.afnFiltering.push(function (
                                      e,
                                      t,
                                      a
                                  ) {
                                      var t = c(t[s]),
                                          n = c(o),
                                          l = c(r);
                                      return (
                                          (n <= t && t <= l) ||
                                          (n <= t && "" === l && "" !== n) ||
                                          (t <= l && "" === n && "" !== l)
                                      );
                                  });
                          })(a, e, t)),
                      r)
                    : r.column(a).search(n, !1, !0)
                ).draw();
            });
        });
    (a = document.querySelector(".dt-responsive")),
        a &&
            new DataTable(a, {
                ajax: assetsPath + "json/table-datatable.json",
                columns: [
                    { data: "id" },
                    { data: "full_name" },
                    { data: "email" },
                    { data: "post" },
                    { data: "city" },
                    { data: "start_date" },
                    { data: "salary" },
                    { data: "age" },
                    { data: "experience" },
                    { data: "status" },
                ],
                columnDefs: [
                    {
                        className: "control",
                        orderable: !1,
                        targets: 0,
                        searchable: !1,
                        render: function (e, t, a, n) {
                            return "";
                        },
                    },
                    {
                        targets: -1,
                        render: function (e, t, a, n) {
                            var a = a.status,
                                l = {
                                    1: {
                                        title: "Current",
                                        class: "bg-label-primary",
                                    },
                                    2: {
                                        title: "Professional",
                                        class: "bg-label-success",
                                    },
                                    3: {
                                        title: "Rejected",
                                        class: "bg-label-danger",
                                    },
                                    4: {
                                        title: "Resigned",
                                        class: "bg-label-warning",
                                    },
                                    5: {
                                        title: "Applied",
                                        class: "bg-label-info",
                                    },
                                };
                            return void 0 === l[a]
                                ? e
                                : `
              <span class="badge ${l[a].class}">
                ${l[a].title}
              </span>
            `;
                        },
                    },
                ],
                destroy: !0,
                layout: {
                    topStart: {
                        rowClass: "row mx-3 my-0 justify-content-between",
                        features: [
                            {
                                pageLength: {
                                    menu: [7, 10, 25, 50, 100],
                                    text: "Show_MENU_entries",
                                },
                            },
                        ],
                    },
                    topEnd: { search: { placeholder: "" } },
                    bottomStart: {
                        rowClass: "row mx-3 justify-content-between",
                        features: ["info"],
                    },
                    bottomEnd: "paging",
                },
                language: {
                    paginate: {
                        next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                        previous:
                            '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                        first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                        last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>',
                    },
                },
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: function (e) {
                                return "Details of " + e.data().full_name;
                            },
                        }),
                        type: "column",
                        renderer: function (e, t, a) {
                            var n,
                                l,
                                s,
                                a = a
                                    .map(function (e) {
                                        return "" !== e.title
                                            ? `<tr data-dt-row="${e.rowIndex}" data-dt-column="${e.columnIndex}">
                      <td>${e.title}:</td>
                      <td>${e.data}</td>
                    </tr>`
                                            : "";
                                    })
                                    .join("");
                            return (
                                !!a &&
                                ((n =
                                    document.createElement(
                                        "div"
                                    )).classList.add("table-responsive"),
                                (l = document.createElement("table")),
                                n.appendChild(l),
                                l.classList.add("table"),
                                ((s =
                                    document.createElement("tbody")).innerHTML =
                                    a),
                                l.appendChild(s),
                                n)
                            );
                        },
                    },
                },
            }),
        (t = document.querySelector(".dt-responsive-child"));
    let i;
    (i = t
        ? new DataTable(t, {
              ajax: assetsPath + "json/table-datatable.json",
              columns: [
                  { data: null },
                  { data: "full_name" },
                  { data: "email" },
                  { data: "city" },
                  { data: "start_date" },
                  { data: "age" },
                  { data: "status" },
              ],
              columnDefs: [
                  {
                      className: "dt-control",
                      orderable: !1,
                      targets: 0,
                      searchable: !1,
                      defaultContent: "",
                  },
                  {
                      targets: -1,
                      render: function (e, t, a, n) {
                          var a = a.status,
                              l = {
                                  1: {
                                      title: "Current",
                                      class: "bg-label-primary",
                                  },
                                  2: {
                                      title: "Professional",
                                      class: "bg-label-success",
                                  },
                                  3: {
                                      title: "Rejected",
                                      class: "bg-label-danger",
                                  },
                                  4: {
                                      title: "Resigned",
                                      class: "bg-label-warning",
                                  },
                                  5: {
                                      title: "Applied",
                                      class: "bg-label-info",
                                  },
                              };
                          return void 0 === l[a]
                              ? e
                              : `
              <span class="badge ${l[a].class}">
                ${l[a].title}
              </span>
            `;
                      },
                  },
              ],
              layout: {
                  topStart: {
                      rowClass: "row mx-3 my-0 justify-content-between",
                      features: [
                          {
                              pageLength: {
                                  menu: [7, 10, 25, 50, 100],
                                  text: "Show_MENU_entries",
                              },
                          },
                      ],
                  },
                  topEnd: { search: { placeholder: "" } },
                  bottomStart: {
                      rowClass: "row mx-3 justify-content-between",
                      features: ["info"],
                  },
                  bottomEnd: "paging",
              },
              scrollX: !0,
              language: {
                  paginate: {
                      next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                      previous:
                          '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                      first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                      last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>',
                  },
              },
          })
        : i).on("click", "td.dt-control", function (e) {
        var e = e.target.closest("tr"),
            e = i.row(e);
        e.child.isShown()
            ? e.child.hide()
            : e
                  .child(
                      "<dl><dt>Full name:</dt><dd>" +
                          (e = e.data()).full_name +
                          "</dd><dt>Post:</dt><dd>" +
                          e.post +
                          "</dd><dt>Salary:</dt><dd>" +
                          e.salary +
                          "</dd><dt>Experience:</dt><dd>" +
                          e.experience +
                          "</dd></dl>"
                  )
                  .show();
    }),
        setTimeout(() => {
            [
                {
                    selector: ".dt-buttons .btn",
                    classToRemove: "btn-secondary",
                },
                {
                    selector: ".dt-search .form-control",
                    classToRemove: "form-control-sm",
                    classToAdd: "ms-4",
                },
                {
                    selector: ".dt-length .form-select",
                    classToRemove: "form-select-sm",
                },
                { selector: ".dt-layout-table", classToRemove: "row mt-2" },
                { selector: ".dt-layout-end", classToAdd: "mt-0" },
                {
                    selector: ".dt-layout-end .dt-search",
                    classToAdd: "mt-md-6 mt-0",
                },
                {
                    selector: ".dt-layout-full",
                    classToRemove: "col-md col-12",
                    classToAdd: "table-responsive",
                },
            ].forEach(({ selector: e, classToRemove: a, classToAdd: n }) => {
                document.querySelectorAll(e).forEach((t) => {
                    a && a.split(" ").forEach((e) => t.classList.remove(e)),
                        n && n.split(" ").forEach((e) => t.classList.add(e));
                });
            });
        }, 100);
});
