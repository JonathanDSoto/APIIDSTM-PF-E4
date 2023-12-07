"use strict";
const formAuthentication = document.querySelector("#formAuthentication");
let form;
document.addEventListener("DOMContentLoaded", function (e) {
    var t;
    form = formAuthentication &&
        FormValidation.formValidation(formAuthentication, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: "Por favor, ingresa un nombre de usuario",
                        },
                        stringLength: {
                            min: 6,
                            message:
                                "El nombre de usuario debe tener más de 6 caracteres",
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Por favor, ingresa tu correo electrónico",
                        },
                        emailAddress: {
                            message:
                                "Por favor, ingresa una dirección de correo electrónico válida",
                        },
                    },
                },
                "email-username": {
                    validators: {
                        notEmpty: {
                            message:
                                "Por favor, ingresa correo electrónico / nombre de usuario",
                        },
                        stringLength: {
                            min: 6,
                            message:
                                "El nombre de usuario debe tener más de 6 caracteres",
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "Por favor, ingresa tu contraseña",
                        },
                        stringLength: {
                            min: 6,
                            message:
                                "La contraseña debe tener más de 6 caracteres",
                        },
                    },
                },
                "confirm-password": {
                    validators: {
                        notEmpty: {
                            message: "Por favor, confirma la contraseña",
                        },
                        identical: {
                            compare: function () {
                                return formAuthentication.querySelector(
                                    '[name="password"]'
                                ).value;
                            },
                            message:
                                "La contraseña y su confirmación no coinciden",
                        },
                        stringLength: {
                            min: 6,
                            message:
                                "La contraseña debe tener más de 6 caracteres",
                        },
                    },
                },
                terms: {
                    validators: {
                        notEmpty: {
                            message:
                                "Por favor, acepta los términos y condiciones",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".mb-3",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                // defaultSubmit: (e) => {
                //     console.log("Hola");
                //     e.preventDefault();
                // },
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (e) => {
                e.on("plugins.message.placed", function (e) {
                    e.element.parentElement.classList.contains("input-group") &&
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                });
            },
        }),
        (t = document.querySelectorAll(".numeral-mask")).length &&
            t.forEach((e) => {
                new Cleave(e, { numeral: !0 });
            });
});
formAuthentication.addEventListener("click", async (e) => {
    e.preventDefault();
    let btn = formAuthentication.querySelector("button");

    if(btn == e.target) {
        const isValid = await form.validate();
        
        if(isValid != "Invalid") {
            let formdata = new FormData();
            formdata.append("email", document.getElementById("email").value);
            formdata.append("password", document.getElementById("password").value);
        
            const url = `${window.location.origin}/api/user/login`;
            let response = await fetch(url, {
                method: "POST",
                body: formdata,
            });
            let data = await response.json();
        
            
            if(response.status == 200) {
                window.localStorage.setItem('user', JSON.stringify(data.result));
                // window.location = "/buildings"
                return;
            }

            Swal.fire({
                title: "¡Oh, no! Algo salio mal :(",
                text: "Compruebe su correo o contraseña e intentelo de nuevo.",
                icon: "error"
            });
        }
    }


});
