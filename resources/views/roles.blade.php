@extends('panel/panel_layout')

@section('title', 'Roles')
@section('content-size', 'xxl')

@section('aditional_header')
    <!-- <link rel="stylesheet" href="{{ asset('../../assets/vendor/libs/leaflet/leaflet.css') }}" /> -->
@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
@endsection


@section('content')
    <h4 class="mb-4">Lista de roles</h4>

    <p class="mb-4">
        Un rol proporciona acceso a menús y funciones predefinidos, de modo que según el rol asignado, un administrador
        puede tener acceso a lo que el usuario necesita.</p>
    <!-- Role cards -->
    <div class="row g-4" id="card-container">
        {{-- Card --}}


        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img src="../../assets/img/illustrations/add-new-roles.png" class="img-fluid mt-sm-4 mt-md-0"
                                alt="add-new-roles" width="83">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-2 text-nowrap add-new-role">Agregar Nuevo Rol</button>
                            <p class="mb-0 mt-1">Agregar rol, si no existe</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/ Role cards -->

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">Agregar Nuevo Rol</h3>
                        <p class="text-muted">Establecer permisos de rol</p>
                    </div>
                    <!-- Add role form -->
                    <form id="addRoleForm" class="row g-3" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalRoleName">Nombre de rol</label>
                            <input type="text" id="modalRoleName" name="modalRoleName" class="form-control"
                                placeholder="Ingrese el nombre del rol" tabindex="-1" />
                        </div>
                        {{-- <div class="col-12">
            <h5>Permisos de rol</h5>
            <!-- Permission table -->
            <div class="table-responsive">
              <table class="table table-flush-spacing">
                <tbody>
                  <tr>
                    <td class="text-nowrap fw-medium">Acceso de administrador <i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i></td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll" />
                        <label class="form-check-label" for="selectAll">
                          Seleccionar todo
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-nowrap fw-medium">Gestión de Usuarios</td>
                    <td>
                      <div class="d-flex">
                        <div class="form-check me-3 me-lg-5">
                          <input class="form-check-input" type="checkbox" id="userManagementRead" />
                          <label class="form-check-label" for="userManagementRead">
                            Lectura
                          </label>
                        </div>
                        <div class="form-check me-3 me-lg-5">
                          <input class="form-check-input" type="checkbox" id="userManagementWrite" />
                          <label class="form-check-label" for="userManagementWrite">
                            Escritura
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="userManagementCreate" />
                          <label class="form-check-label" for="userManagementCreate">
                            Crear
                          </label>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Permission table -->
          </div> --}}
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Confirmar</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('aditional_scripts')
    <script>
        const card_container = document.getElementById('card-container');

        async function mostrarRoles() {
            const request = await fetch(`${window.location.origin}/api/roles`);

            if (request.status != 200) {
                Swal.fire({
                    title: "¡Oh no! Hubo un error con cargar los roles",
                    text: "Intentelo mas tarde o comuniquese con un administrador.",
                    icon: "error"
                });
                return;
            }

            const data = await request.json();
            console.log(data);
            if (!data) {
                Swal.fire({
                    title: "No hay roles registrados :(",
                    text: "Intentelo mas tarde o comuniquese con un administrador.",
                    icon: "error"
                });
                return;
            }

            data.forEach(role => {
                const new_card = `
              <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="card">
                      <div class="card-body">
                          <div class="d-flex justify-content-between">
                              <h6 class="fw-normal mb-2">${role.users.length} Usuarios</h6>
                          </div>
                          <div class="d-flex justify-content-between align-items-end mt-1">
                              <div class="role-heading">
                                  <h4 class="mb-1">${role.name}</h4>
                                  <a href="javascript:;" data-name="${role.name}" data-id="${role.id}" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                                      class="role-edit-modal"><span>Editar Rol</span></a>
                              </div>
                              {{-- boton borrar --}}
                              <a href="javascript:void(0);" onclick="mostrarEliminar(this)" class="text-muted"><i class="ti ti-trash ti-md"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
              `;

                card_container.innerHTML += new_card;
            });
        }

        function mostrarEliminar() {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '¡Quiero eliminar el campo!',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */

                if (result.isConfirmed) {



                } else if (result.isDenied) {



                }
            })

            Swal.fire({
                title: "Este rol cuenta con usuarios, escoge el rol que se les reemplazara",
                input: "select",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Look up",
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                    });
                }
            });
        }

        mostrarRoles();
    </script>
@endsection
