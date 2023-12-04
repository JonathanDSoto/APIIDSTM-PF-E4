"use strict";
$(function () {
    let t, a, s;
    let tableInfo;
    s = (
        isDarkStyle
            ? ((t = config.colors_dark.borderColor),
                (a = config.colors_dark.bodyBg),
                config.colors_dark)
            : ((t = config.colors.borderColor),
                (a = config.colors.bodyBg),
                config.colors)
    ).headingColor;
    var e,
        n = $(".datatables-users"),
        i = $(".select2"),
        r = "#",
        o = {
            1: { title: "Pending", class: "bg-label-warning" },
            2: { title: "Active", class: "bg-label-success" },
            3: { title: "Inactive", class: "bg-label-secondary" },
        };
    i.length &&
        (i = i)
            .wrap('<div class="position-relative"></div>')
            .select2({
                placeholder: "Select Country",
                dropdownParent: i.parent(),
            }),
        n.length &&
        (e = n.DataTable({
            ajax: {
                url: `${window.location.origin}/api/user`,
                method: 'GET',
                dataType: 'json',
                dataSrc: '',
                beforeSend: function (xhr) {
                    // Agregar el token de autorización al encabezado
                    xhr.setRequestHeader('Authorization', `Bearer ${window.user_info?.api_token ?? ""}`); // Reemplaza 'TU_TOKEN' con tu token real
                },
                complete: (e) => {
                    if(e.status === 401) {
                        window.localStorage.removeItem('user');
                        window.location.href = "/";
                        return;
                    } 

                    window.tableInfo = e.responseJSON;
                }
            },
            columns: [
                { data: "" },
                { data: "uuid" },
                { data: "name" },
                { data: "lastname" },
                { data: "email" },
                // { data: "image_name" },
                { data: "role" },
                { data: "action" },
            ],
            columnDefs: [
                {
                    className: "control",
                    searchable: !1,
                    orderable: !1,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (e, t, a, s) {
                        return "";
                    },
                },
                {
                    targets: 1,
                    render: function (e, t, a, s) {
                        var id = a.id;
                        return (id
                            // '<span class="fw-medium">' +
                            // a.current_plan +
                            // "</span>"
                        );
                    },
                },
                {
                    targets: 2,
                    responsivePriority: 4,
                    render: function (e, t, a, s) {
                        var { name } = a,
                            i = a.email,
                            o = a.avatar;
                        return (name
                            // '<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar me-3">' +
                            // (o
                            //     ? '<img src="' +
                            //     assetsPath +
                            //     "img/avatars/" +
                            //     o +
                            //     '" alt="Avatar" class="rounded-circle">'
                            //     : '<span class="avatar-initial rounded-circle bg-label-' +
                            //     [
                            //         "success",
                            //         "danger",
                            //         "warning",
                            //         "info",
                            //         "primary",
                            //         "secondary",
                            //     ][Math.floor(6 * Math.random())] +
                            //     '">' +
                            //     (o = (
                            //         ((o =
                            //             (n = a.full_name).match(
                            //                 /\b\w/g
                            //             ) || []).shift() || "") +
                            //         (o.pop() || "")
                            //     ).toUpperCase()) +
                            //     "</span>") +
                            // '</div></div><div class="d-flex flex-column"><a href="' +
                            // r +
                            // '" class="text-body text-truncate"><span class="fw-medium">' +
                            // n +
                            // '</span></a><small class="text-muted">' +
                            // i +
                            // "</small></div></div>"
                        );
                    },
                },
                {
                    targets: 3,
                    render: function (e, t, { lastname }, s) {

                        return (lastname
                            // "<span class='text-truncate d-flex align-items-center'>" +
                            // {
                            //     Subscriber:
                            //         '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="ti ti-user ti-sm"></i></span>',
                            //     Author: '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i class="ti ti-circle-check ti-sm"></i></span>',
                            //     Maintainer:
                            //         '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="ti ti-chart-pie-2 ti-sm"></i></span>',
                            //     Editor: '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30 me-2"><i class="ti ti-edit ti-sm"></i></span>',
                            //     Admin: '<span class="badge badge-center rounded-pill bg-label-secondary w-px-30 h-px-30 me-2"><i class="ti ti-device-laptop ti-sm"></i></span>',
                            // }[a] +
                            // a +
                            // "</span>"
                        );
                    },
                },
                {
                    targets: 4,
                    render: function (e, t, { email }, s) {
                        return (email
                            // '<span class="fw-medium">' +
                            // a.current_plan +
                            // "</span>"
                        );
                    },
                },
                {
                    targets: 5,
                    filter: function (data, type, row, meta) {
                        return "hola"
                    },
                    render: function (e, t, a, s) {
                        a = a.role;
                        return (a.name
                            // '<span class="badge ' +
                            // o[a].class +
                            // '" text-capitalized>' +
                            // o[a].title +
                            // "</span>"
                        );
                    },
                },
                {
                    targets: 6,
                    title: "Actions",
                    searchable: !1,
                    orderable: !1,
                    render: function (e, t, a, s) {
                        // if(window.user_info.id == a.id)- return "";
                        return (
                            `
                            <div class="d-flex align-items-center">
                                <a id="editButton" data-uuid="${a.id}" href="javascript:;" class="text-body">
                                    <i class="ti ti-edit ti-sm me-2">
                                    </i>
                                </a>
                                <a data-email="${a.email}" data-uuid="${a.id}" href="javascript:;" class="text-body delete-record">
                                    <i class="ti ti-trash ti-sm mx-2">
                                    </i>
                                </a>
                                </div>
                                `
                                // <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                //     <i class="ti ti-dots-vertical ti-sm mx-1">
                                //     </i>
                                // </a>
                                // <div class="dropdown-menu dropdown-menu-end m-0">
                                //     <a href="' + r + '" class="dropdown-item">View</a>
                                //     <a href="javascript:;" class="dropdown-item">Suspend</a>
                                // </div>
                        );
                    },
                },
            ],
            order: [[1, "desc"]],
            dom: '<"row me-2"<"col-md-2"<"me-3"l>><"col-md-10"<"gap-3 dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Buscar",
            },
            buttons: [

                {
                    text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Agregar Usuario</span>',
                    className: "add-new btn btn-primary",
                    attr: {
                        "data-bs-toggle": "modal",
                        "data-bs-target": "#modalAddUser",
                    },
                },
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (e) {
                            return "Details of " + e.data().full_name;
                        },
                    }),
                    type: "column",
                    renderer: function (e, t, a) {
                        a = $.map(a, function (e, t) {
                            return "" !== e.title
                                ? '<tr data-dt-row="' +
                                e.rowIndex +
                                '" data-dt-column="' +
                                e.columnIndex +
                                '"><td>' +
                                e.title +
                                ":</td> <td>" +
                                e.data +
                                "</td></tr>"
                                : "";
                        }).join("");
                        return (
                            !!a &&
                            $('<table class="table"/><tbody />').append(a)
                        );
                    },
                },
            },
            initComplete: function () {
                this.api()
                    .columns(5)
                    .every(function () {
                        var t = this,
                            a = $(
                                '<select id="UserRole" class="form-select text-capitalize"><option value=""> Seleccione un rol </option></select>'
                            )
                                .appendTo(".user_role")
                                .on("change", function () {
                                    var e = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    t.search(
                                        e ? "^" + e + "$" : "",
                                        !0,
                                        !1
                                    ).draw();
                                });
                        t.data()
                            .unique()
                            .sort()
                            .each(function (e, t) {
                                a.append(
                                    '<option value="' +
                                    e.name +
                                    '">' +
                                    e.name +
                                    "</option>"
                                );
                            });
                    })
                // this.api()
                //     .columns(3)
                //     .every(function () {
                //         var t = this,
                //             a = $(
                //                 '<select id="UserPlan" class="form-select text-capitalize"><option value=""> Select Plan </option></select>'
                //             )
                //                 .appendTo(".user_plan")
                //                 .on("change", function () {
                //                     var e =
                //                         $.fn.dataTable.util.escapeRegex(
                //                             $(this).val()
                //                         );
                //                     t.search(
                //                         e ? "^" + e + "$" : "",
                //                         !0,
                //                         !1
                //                     ).draw();
                //                 });
                //         t.data()
                //             .unique()
                //             .sort()
                //             .each(function (e, t) {
                //                 a.append(
                //                     '<option value="' +
                //                     e +
                //                     '">' +
                //                     e +
                //                     "</option>"
                //                 );
                //             });
                //     }),
                // this.api()
                //     .columns(5)
                //     .every(function () {
                //         var t = this,
                //             a = $(
                //                 '<select id="FilterTransaction" class="form-select text-capitalize"><option value=""> Select Status </option></select>'
                //             )
                //                 .appendTo(".user_status")
                //                 .on("change", function () {
                //                     var e =
                //                         $.fn.dataTable.util.escapeRegex(
                //                             $(this).val()
                //                         );
                //                     t.search(
                //                         e ? "^" + e + "$" : "",
                //                         !0,
                //                         !1
                //                     ).draw();
                //                 });
                //         t.data()
                //             .unique()
                //             .sort()
                //             .each(function (e, t) {
                //                 a.append(
                //                     '<option value="' +
                //                     o[e].title +
                //                     '" class="text-capitalize">' +
                //                     o[e].title +
                //                     "</option>"
                //                 );
                //             });
                //     });
                $(".datatables-users").on("click", "#editButton", function () {
                    let element = document.getElementById('editButton');
                    console.log(window.tableInfo.filter((user) => user.id == element.dataset.uuid)[0]);
                
                    // Aquí puedes realizar la lógica de edición con el uuid del registro
                    // Por ejemplo, puedes redirigir a una página de edición con el uuid en la URL
                    // window.location.href = `/editar-usuario/${uuid}`;
                });
            },
        })),
        
        $(".datatables-users tbody").on("click", ".delete-record", async function (element) {
            const {uuid, email} = element.target.parentElement.dataset;

            Swal.fire({
                title: `¿Confirma que desea eliminar al usuario con el correo ${email}?`,
                text: "¡No sera posible revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, quiero eliminarlo!",
                cancelButtonText: "Cancelar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let response = await fetch(`${window.location.origin}/api/user/${uuid}`, {
                        method: 'DELETE',
                        headers: new Headers({
                            'Authorization': `Bearer ${window.user_info.api_token}`
                        })
                    });
        
                    if(response.status == 200) {
                        e.row($(this).parents("tr")).remove().draw();
                        Swal.fire({
                            title: "¡Eliminado!",
                            text: "Usuario eliminado.",
                            icon: "success"
                        });
                    } else {
                        alert("Hubo un error, intentelo de nuevo.")
                    }
                }
            });

            

        }),
        setTimeout(() => {
            $(".dataTables_filter .form-control").removeClass(
                "form-control-sm"
            ),
                $(".dataTables_length .form-select").removeClass(
                    "form-select-sm"
                );
        }, 300);
}),
    (function () {
        var e = document.querySelectorAll(".phone-mask"),
            t = document.getElementById("addNewUserForm");
        e &&
            e.forEach(function (e) {
                new Cleave(e, { phone: !0, phoneRegionCode: "US" });
            }),
            FormValidation.formValidation(t, {
                fields: {
                    userFullname: {
                        validators: {
                            notEmpty: { message: "Please enter fullname " },
                        },
                    },
                    userEmail: {
                        validators: {
                            notEmpty: { message: "Please enter your email" },
                            emailAddress: {
                                message:
                                    "The value is not a valid email address",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: "",
                        rowSelector: function (e, t) {
                            return ".mb-3";
                        },
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    autoFocus: new FormValidation.plugins.AutoFocus(),
                },
            });
    })();
