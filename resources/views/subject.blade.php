@extends('panel/panel_layout')

@section('title', 'Materias')
@section('content-size', 'xxl')

@section('aditional_header')
    
@endsection

@section('aditional_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/js/forms-file-upload.js"></script>


<script>
        // Función para abrir el modal de edición con los datos de la materia
        function abrirModalEditar(nombre, idDepartamento) {
            var modal = new bootstrap.Modal(document.getElementById('editarModal'));

            // Colocar los datos actuales en el formulario
            document.getElementById('nombre').value = nombre;
            document.getElementById('departamento').value = idDepartamento;

            modal.show();
        }

        // Función para abrir el modal de eliminar con los datos de la materia
        function abrirModalEliminar(e) {
          const {name} = e.parentElement.dataset;
          
          Swal.fire({
                    title: `¿Confirma que desea eliminar la materia "${name}"?`,
                    text: "¡No sera posible revertir esta acción!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Si, quiero eliminarlo!",
                    cancelButtonText: "Cancelar",
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // let response = await fetch(
                        //     `${window.location.origin}/api/user/${uuid}`,
                        //     {
                        //         method: "DELETE",
                        //         headers: new Headers({
                        //             Authorization: `Bearer ${window.user_info.api_token}`,
                        //         }),
                        //     }
                        // );

                        // if (response.status == 200) {
                        //     e.row($(this).parents("tr")).remove().draw();
                        //     Swal.fire({
                        //         title: "¡Eliminado!",
                        //         text: "Usuario eliminado.",
                        //         icon: "success",
                        //     });
                        // } else {
                        //     alert("Hubo un error, intentelo de nuevo.");
                        // }
                    }
                });
        }

         // Función para guardar los cambios (simulada)
        function guardarCambios() {
            // Obtener los valores del formulario
            var nombre = document.getElementById('nombre').value;
            var idDepartamento = document.getElementById('departamento').value;

            // Realizar acciones de guardado (simuladas)
            console.log('Guardando cambios para la materia: ', nombre, idDepartamento);

            // Cerrar el modal después de guardar
            var modal = new bootstrap.Modal(document.getElementById('editarModal'));
            modal.hide();
        }
    </script>
@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />
   
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">UABCS/</span> Materias</h4>

    <div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between gap-3">
      <div class="card-title mb-0 me-1">
        <h5 class="mb-1">Materias</h5>
        <p class="text-muted mb-0">¡Alrededor de 100 materias que estudiantes pueden disfrutar!</p>
      </div>
    </div>
    <div class="card-body">
      <div class="row gy-4 mb-4" id="cards_container">

        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-1.png" alt="tutor image 1" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-primary">DASC</span>
                <!-- <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  4.4 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted">(1.23k)</span>
                </h6> -->
              </div>
              <a href="app-academy-course-details.html" class="h5">Basics of Angular</a>
              <p class="mt-2">Introductory course for Angular and framework basics in web development.</p>
              <!-- <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>30 minutes</p> -->
              <!-- <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-75" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div> -->
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap" data-id="" data-name="Basic of Angular">

                <a onclick="abrirModalEliminar(this)" class="app-academy-md-50 btn btn-label-danger me-md-2 d-flex align-items-center w-100" href="javascript:;">
                  <i class="ti ti-trash align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Eliminar</span>
                </a>
                <a onclick="abrirModalEditar(this)" class="app-academy-md-50 btn btn-label-primary d-flex align-items-center w-100" href="javascript:;">
                  <span class="me-2">Modificar</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>

              </div>
            </div>
          </div>
        </div>
      
      </div>
      <!-- <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
        <ul class="pagination">
          <li class="page-item prev">
            <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left ti-xs scaleX-n1-rtl"></i></a>
          </li>
          <li class="page-item active">
            <a class="page-link" href="javascript:void(0);">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">4</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">5</a>
          </li>
          <li class="page-item next">
            <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right ti-xs scaleX-n1-rtl"></i></a>
          </li>
        </ul>
      </nav> -->
    </div>
  </div>

    <!-- Modales -->
    <!-- Modal de Edición -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Materia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición -->
                    <!-- <form id="editarForm"> -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la materia">
                        </div>
                        
                        <div class="mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" placeholder="ID del Departamento">
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                              <label for="nameBasic" class="form-label">Foto de Materia</label>
                              <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                                  id="dropzone-basic">
                                  <div class="dz-message needsclick">
                                      Arrastre la imagen aquí o haz clic para subirla
                                      {{-- <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                      <span class="fw-medium">not</span> actually uploaded.)</span> --}}
                                  </div>
                                  <div class="fallback">
                                      <input name="file" type="file" accept=".jpg, .jpeg, .png" />
                                  </div>
                              </form>
                          </div>
                      </div>

                      
                    <!-- </form> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Eliminación -->
    <!-- <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModalLabel">Eliminar Materia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> -->
                    <!-- Contenido del mensaje de confirmación de eliminación -->
                    <!-- <p id="mensajeEliminar">¿Estás seguro de que deseas eliminar la materia?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarMateria()">Eliminar</button>
                </div>
            </div>
        </div>
    </div> -->
    
@endsection
