@extends('panel/panel_layout')

@section('title', 'Materias')
@section('content-size', 'xxl')

@section('aditional_header')
    
@endsection

@section('aditional_scripts')
<script src="../../assets/vendor/libs/bootstrap.bundle.min.js"></script>
<!-- Bootstrap JS (requiere Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-cvDE4x4ZL1FexI6uIA6ihlD8gj6I5d2IFb2U4J0jzWBfcaYaILwGfMDDPzAaP1z" crossorigin="anonymous"></script>
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="{{ asset('../../assets/vendor/js/lit.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/card-btn.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/building-card.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--
<script src="../../assets/js/ui-modals.js"></script> --}}

<script>
    // Asegúrate de incluir este script después de cargar la página
    Dropzone.autoDiscover = false; // Evita que Dropzone.js se inicialice automáticamente

    var myDropzone = new Dropzone("#dropzone-basic", {
        url: "https://demos.pixinvent.com/upload", // Cambia la URL según tus necesidades
        paramName: "file",
        acceptedFiles: ".jpg, .jpeg, .png",
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar archivo",
        // Puedes agregar más opciones según tus necesidades
    });
</script>


@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/vendor/libs/fontawesome/css/all.min.css">
    
    <!-- Row Group CSS -->
  <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-rbsPfWKQmkszyoS3Jvg4BgbSkysGFF0pNYjijXx4XyMn5Y+5V/g7EZ65hEZd5iFs" crossorigin="anonymous">

    
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">UABCS/</span> Materias</h4>

    <div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between gap-3">
      <div class="card-title mb-0 me-1">
        <h5 class="mb-1">Materias</h5>
        <p class="text-muted mb-0">¡Alrededor de 100 materias que estudiantes pueden disfrutar!</p>
      </div>
      <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">
        <!-- <select id="select2_course_select" class="select2 form-select" data-placeholder="All Courses">
          <option value="">All Courses</option>
          <option value="ui/ux">UI/UX</option>
          <option value="seo">SEO</option>
          <option value="web">Web</option>
          <option value="music">Music</option>
          <option value="painting">Painting</option>
        </select> -->

        <!-- <label class="switch">
          <input type="checkbox" class="switch-input">
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label text-nowrap mb-0">Hide completed</span>
        </label> -->
      </div>
    </div>
    <div class="card-body">
      <div class="row gy-4 mb-4">
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-1.png" alt="tutor image 1" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-primary">Web</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  4.4 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted">(1.23k)</span>
                </h6>
              </div>
              <a href="app-academy-course-details.html" class="h5">Basics of Angular</a>
              <p class="mt-2">Introductory course for Angular and framework basics in web development.</p>
              <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>30 minutes</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-75" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
                <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center w-100" href="app-academy-course-details.html">
                  <i class="ti ti-rotate-clockwise-2 align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Start Over</span>
                </a>
                <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center w-100" href="app-academy-course-details.html">
                  <span class="me-2">Continue</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-2.png" alt="tutor image 2" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3 pe-xl-3 pe-xxl-0">
                <span class="badge bg-label-danger">UI/UX</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  4.2 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted"> (424)</span>
                </h6>
              </div>
              <a class="h5" href="app-academy-course-details.html">Figma & More</a>
              <p class="mt-2">Introductory course for design and framework basics in web development.</p>
              <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>16 hours</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
                <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                  <i class="ti ti-rotate-clockwise-2 align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Start Over</span>
                </a>
                <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                  <span class="me-2">Continue</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-3.png" alt="tutor image 3" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-success">SEO</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  5 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted"> (12)</span>
                </h6>
              </div>
              <a class="h5" href="app-academy-course-details.html">Keyword Research</a>
              <p class="mt-2">Keyword suggestion tool provides comprehensive details & suggestions.</p>
              <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>7 hours</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-50" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
                <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                  <i class="ti ti-rotate-clockwise-2 align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Start Over</span>
                </a>
                <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                  <span class="me-2">Continue</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-4.png" alt="tutor image 4" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-info">Music</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  3.8 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted"> (634)</span>
                </h6>
              </div>
              <a class="h5" href="app-academy-course-details.html">Basics to Advanced</a>
              <p class="mt-2">20 more lessons like this about music production, writing, mixing, mastering</p>
              <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>30 minutes</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-75" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
                <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                  <i class="ti ti-rotate-clockwise-2 align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Start Over</span>
                </a>
                <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                  <span class="me-2">Continue</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-5.png" alt="tutor image 5" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-warning">Painting</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  4.7 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted"> (34)</span>
                </h6>
              </div>
              <a class="h5" href="app-academy-course-details.html">Art & Drawing</a>
              <p class="mt-2">Easy-to-follow video & guides show you how to draw animals, people & more.</p>
              <p class="d-flex align-items-center text-success"><i class="ti ti-checks me-2 mt-n1"></i>Completed</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-100" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <a class="w-100 btn btn-label-primary" href="app-academy-course-details.html"><i class="ti ti-rotate-clockwise-2 me-2 mt-n1 scaleX-n1-rtl"></i>Start Over</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-3">
              <a href="app-academy-course-details.html"><img class="img-fluid" src="../../assets/img/pages/app-academy-tutor-6.png" alt="tutor image 6" /></a>
            </div>
            <div class="card-body p-3 pt-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-label-danger">UI/UX</span>
                <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                  3.6 <span class="text-warning"><i class="ti ti-star-filled me-1 mt-n1"></i></span><span class="text-muted"> (2.5k)</span>
                </h6>
              </div>
              <a class="h5" href="app-academy-course-details.html">Basics Fundamentals</a>
              <p class="mt-2">This guide will help you develop a systematic and programmatic approach user interface.</p>
              <p class="d-flex align-items-center"><i class="ti ti-clock me-2 mt-n1"></i>16 hours</p>
              <div class="progress mb-4" style="height: 8px">
                <div class="progress-bar w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
                <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                  <i class="ti ti-rotate-clockwise-2 align-middle scaleX-n1-rtl  me-2 mt-n1 ti-sm"></i><span>Start Over</span>
                </a>
                <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                  <span class="me-2">Continue</span><i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
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
      </nav>
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
                    <form id="editarForm">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Eliminación -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModalLabel">Eliminar Materia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del mensaje de confirmación de eliminación -->
                    <p id="mensajeEliminar">¿Estás seguro de que deseas eliminar la materia?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarMateria()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Iterar sobre las materias
        var materias = [
            ['Materia 1', 'ID_Departamento1', '../../assets/img/elements/13.jpg'],
            ['Materia 2', 'ID_Departamento2', '../../assets/img/elements/13.jpg'],
            ['Materia 3', 'ID_Departamento3', '../../assets/img/elements/13.jpg'],
        ];

        // Obtener el contenedor de materias
        var materiasContainer = document.getElementById('materias-container');

        materias.forEach(function (materia) {
            var [nombre, idDepartamento, rutaImagen] = materia;

             // Generar código HTML para cada materia
            var materiaHtml = `
                <div class='col-md-4 mb-2'>
                    <div class='card border-primary shadow-sm'>
                        <img src='${rutaImagen}' class='card-img-top img-fluid' alt='Imagen de la materia' style='max-height: 200px;'>
                        <div class='card-body'>
                            <h5 class='card-title text-truncate'>$nombre</h5>
                            <p class='card-text'><strong>ID del Departamento:</strong> $idDepartamento</p>
                            
                            <!-- Utilizando justify-content-end para alinear a la derecha -->
                            <div class='d-flex justify-content-end'>
                                <a href='#' class='btn btn-info m-1' onclick="abrirModalEditar('${nombre}', '${idDepartamento}')">
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a href='#' class='btn btn-danger m-1' onclick="abrirModalEliminar('${nombre}', '${idDepartamento}')">
                                    <i class='fas fa-trash'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Agregar el HTML de la materia al contenedor
            materiasContainer.innerHTML += materiaHtml;
        });

        // Función para abrir el modal de edición con los datos de la materia
        function abrirModalEditar(nombre, idDepartamento) {
            var modal = new bootstrap.Modal(document.getElementById('editarModal'));

            // Colocar los datos actuales en el formulario
            document.getElementById('nombre').value = nombre;
            document.getElementById('departamento').value = idDepartamento;

            modal.show();
        }

        // Función para abrir el modal de eliminar con los datos de la materia
        function abrirModalEliminar(nombre) {
            var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));

            // Colocar los datos actuales en el mensaje de confirmación
            document.getElementById('eliminarModalLabel').textContent = `Eliminar Materia - ${nombre}`;
            document.getElementById('mensajeEliminar').textContent = `¿Estás seguro de que deseas eliminar la materia ${nombre}?`;

            modal.show();
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

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../../assets/vendor/libs/jquery.min.js"></script>
    <script src="../../assets/vendor/libs/bootstrap.bundle.min.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/form-layouts.js"></script>
    <script src="../../assets/js/form-wizard-numbered.js"></script>
    <script src="../../assets/js/form-wizard-validation.js"></script>
@endsection
