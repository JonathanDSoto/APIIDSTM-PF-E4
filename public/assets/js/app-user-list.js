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
        (i = i).wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Country",
            dropdownParent: i.parent(),
        }),
        n.length &&
            (e = n.DataTable({
                ajax: {
                    url: `${window.location.origin}/api/user`,
                    method: "GET",
                    dataType: "json",
                    dataSrc: "",
                    beforeSend: function (xhr) {
                        // Agregar el token de autorización al encabezado
                        xhr.setRequestHeader(
                            "Authorization",
                            `Bearer ${window.user_info?.api_token ?? ""}`
                        ); // Reemplaza 'TU_TOKEN' con tu token real
                    },
                    complete: (e) => {
                        if (e.status === 401) {
                            window.localStorage.removeItem("user");
                            window.location.href = "/";
                            return;
                        }

                        window.tableInfo = e.responseJSON;
                        window.reloadForm =
                            $(".datatables-users").DataTable().ajax.reload;
                    },
                },
                columns: [
                    { data: "" },
                    { data: "uuid" },
                    { data: "name" },
                    { data: "lastname" },
                    { data: "email" },
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
                            return id;
                        },
                    },
                    {
                        targets: 2,
                        responsivePriority: 4,
                        render: function (e, t, a, s) {
                            var { name } = a,
                                i = a.email,
                                o = a.avatar;
                            return name;
                        },
                    },
                    {
                        targets: 3,
                        render: function (e, t, { lastname }, s) {
                            return lastname;
                        },
                    },
                    {
                        targets: 4,
                        render: function (e, t, { email }, s) {
                            return email;
                        },
                    },
                    {
                        targets: 5,
                        filter: function (data, type, row, meta) {
                            return "hola";
                        },
                        render: function (e, t, a, s) {
                            a = a.role;
                            return a.name;
                        },
                    },
                    {
                        targets: 6,
                        title: "Acciones",
                        searchable: !1,
                        orderable: !1,
                        render: function (e, t, a, s) {
                            if (window.user_info.id == a.id) return "";
                            return `
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
                                `;
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
                        text: '<i id="addBtn" class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Agregar Usuario</span>',
                        className: "add-new btn btn-primary",
                        attr: {
                            // "data-bs-toggle": "modal",
                            // "data-bs-target": "#modalAddUser",
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
                        });
                    $(".datatables-users").on(
                        "click",
                        "#editButton",
                        function (e) {
                            // let element = document.getElementById('editButton');
                            let user = window.tableInfo.filter(
                                (user) =>
                                    user.id == e.currentTarget.dataset.uuid
                            )[0];

                            console.log(
                                window.tableInfo.filter(
                                    (user) =>
                                        user.id == e.currentTarget.dataset.uuid
                                )[0]
                            );

                            const label =
                                document.getElementById("modalAddUserLabel");
                            const oldLabel = label.textContent;
                            label.textContent = "Editar usuario";

                            const btn = document.querySelector(".data-submit");
                            const oldbtn = btn.textContent;
                            btn.textContent = "Aplicar";

                            let modal = new bootstrap.Modal(
                                document.getElementById("modalAddUser")
                            );
                            modal.show();

                            let nameInput =
                                document.getElementById("add-user-name");
                            let lastnameInput =
                                document.getElementById("add-user-lastname");
                            let emailInput =
                                document.getElementById("add-user-email");
                            let passwordInput =
                                document.getElementById("add-user-password");
                            let roleInput =
                                document.getElementById("user-role");
                            // let roleInput = document.getElementById("user-role");

                            nameInput.value = user.name;
                            lastnameInput.value = user.lastname;
                            emailInput.value = user.email;
                            // passwordInput.value = user.;
                            roleInput.value = user.role_id;

                            let submitBtn = (document.querySelector(
                                ".data-submit"
                            ).onclick = async () => {
                                let isValid =
                                    await window.formvalidation.validate();

                                if (isValid != "Invalid") {
                                    let form = new FormData();
                                    form.append("name", nameInput.value);
                                    form.append(
                                        "lastname",
                                        lastnameInput.value
                                    );
                                    form.append("email", emailInput.value);
                                    if (passwordInput.value.trim()) {
                                        form.append(
                                            "password",
                                            passwordInput.value
                                        );
                                    }
                                    form.append("role_id", roleInput.value);

                                    let response = await fetch(
                                        `${window.location.origin}/api/user/${user.id}`,
                                        {
                                            method: "POST",
                                            headers: new Headers({
                                                Authorization: `Bearer ${window.user_info?.api_token}`,
                                            }),
                                            body: form,
                                        }
                                    );

                                    let data = await response.json();

                                    if (response.status == 200) {
                                        Swal.fire({
                                            title: "¡Excelente! Los cambios fueron aplicados satisfactoriamente",
                                            text: "La informacion del usuario ha sido cambiada con exito.",
                                            icon: "success",
                                        });
                                        modal.hide();
                                        window.reloadForm();
                                        // $(".datatables-users").DataTable().ajax.reload();
                                    }
                                }
                            });

                        }
                    );
                },
            })),
        $(".datatables-users tbody").on(
            "click",
            ".delete-record",
            async function (element) {
                const { uuid, email } = element.target.parentElement.dataset;

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
                        let response = await fetch(
                            `${window.location.origin}/api/user/${uuid}`,
                            {
                                method: "DELETE",
                                headers: new Headers({
                                    Authorization: `Bearer ${window.user_info.api_token}`,
                                }),
                            }
                        );

                        if (response.status == 200) {
                            e.row($(this).parents("tr")).remove().draw();
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "Usuario eliminado.",
                                icon: "success",
                            });
                        } else {
                            alert("Hubo un error, intentelo de nuevo.");
                        }
                    }
                });
            }
        ),
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
        window.formvalidation = FormValidation.formValidation(t, {
            fields: {
                userName: {
                    validators: {
                        notEmpty: { message: "Ingrese un nombre" },
                    },
                },
                userLastName: {
                    validators: {
                        notEmpty: { message: "Ingrese un apellido" },
                    },
                },
                userEmail: {
                    validators: {
                        notEmpty: { message: "Ingrese un Email" },
                        emailAddress: {
                            message:
                                "El valor no es una dirección de correo electrónico válida.",
                        },
                    },
                },
                userPassword: {
                    validators: {
                        // notEmpty: {
                        //     message: "Ingrese una contraseña"
                        // },
                        stringLength: {
                            min: 6,
                            message:
                                "La contraseña debe tener más de 6 caracteres",
                        },
                    },
                },
                userConfirmPassword: {
                    validators: {
                        // notEmpty: {
                        //     message: "Por favor, confirma la contraseña",
                        // },
                        identical: {
                            compare: function () {
                                return document.querySelector(
                                    '[name="userPassword"]'
                                ).value;
                            },
                            message:
                                "La contraseña y su confirmación no coinciden",
                        },
                        // stringLength: {
                        //     min: 6,
                        //     message:
                        //         "La contraseña debe tener más de 6 caracteres",
                        // },
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
        e &&
            e.forEach(function (e) {
                new Cleave(e, { phone: !0, phoneRegionCode: "US" });
            }),
            window.formvalidation;
    })();
