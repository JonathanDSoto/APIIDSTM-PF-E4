@extends('panel/panel_layout')

@section('title', 'Iniciativa')
@section('content-size', 'xxl')

@section('aditional_header')
    
    
@endsection

@section('aditional_scripts')


@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css" />

   
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!-- Form Validation -->
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

    <style>
      .delete-button {
        padding: 2px 2px;
      }

      .delete-button i {
        font-size: 1.2rem;
      }

      .delete-button:hover {
        color: #fff;
        background-color: #dc3545; 
        border-color: #dc3545; 
      }
    </style>

 
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">UBACS</span> Iniciativas
    </h4>

    <div class="row" id="iniciativas-container">
        <!-- Contenedor de iniciativas generado dinámicamente con JavaScript -->
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar la iniciativa "<span id="modalTituloIniciativa"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="eliminarIniciativaBtn">
                        <i class="ti ti-trash me"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Iniciativa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del formulario de edición -->
                    <form>
                        <div class="mb-3">
                            <label for="tituloIniciativa" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloIniciativa" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionIniciativa" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionIniciativa" rows="3" disabled></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="estadoIniciativa" class="form-label">Estado</label>
                            <select class="form-select" id="estadoIniciativa">
                                <option value="Aprobada">Aprobada</option>
                                <option value="No Aprobada">No Aprobada</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fechaIniciativa" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="fechaIniciativa" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="departamentoIniciativa" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamentoIniciativa" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarCambiosBtn">
                        <i class="ti ti-check me"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Array de iniciativas
        var iniciativas = [
            {
                titulo: 'Angular Project',
                descripcion: 'Breve descripción del proyecto...',
                estado: 'Aprobada',
                imagen: '../../assets/img/elements/10.jpg',
                usuario_img: '../../assets/img/avatars/5.png',
                fecha: '2023-01-01',
                departamento: 'Desarrollo'
            },
            {
                titulo: 'Validar Horarios',
                descripcion: 'Breve descripción del proyecto...',
                estado: 'Aprobada',
                imagen: '../../assets/img/elements/12.jpg',
                usuario_img: '../../assets/img/avatars/6.png',
                fecha: '2023-02-01',
                departamento: 'Recursos Humanos'
            },
            {
                titulo: 'Limpiar Baños',
                descripcion: 'Breve descripción del proyecto...',
                estado: 'No Aprobada',
                imagen: '../../assets/img/elements/13.jpg',
                usuario_img: '../../assets/img/avatars/7.png',
                fecha: '2023-03-01',
                departamento: 'Mantenimiento'
            }
        ];

        // Obtener el contenedor de iniciativas
        var iniciativasContainer = document.getElementById('iniciativas-container');

        // Iterar sobre las iniciativas
        iniciativas.forEach(function (iniciativa) {
            var tituloIniciativa = iniciativa.titulo;

            // Generar código HTML para cada iniciativa
            var iniciativaHtml = `
                <div class='col-md-4 mb-4'>
                    <div class='card ios-card position-relative'>
                        <div class='position-absolute top-0 end-0 m-4'>
                            <div class='d-flex'>
                                <button type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' class='btn btn-outline-danger btn-sm delete-button' data-title='${tituloIniciativa}'>
                                    <i class='ti ti-trash'></i>
                                </button>
                                <button type='button' data-bs-toggle='modal' data-bs-target='#editModal' class='btn btn-outline-primary btn-sm edit-button ms-2' data-title='${tituloIniciativa}' data-status='${iniciativa.estado}'>
                                    <i class='ti ti-pencil'></i>
                                </button>
                            </div>
                        </div>
                        <h5 class='card-header ios-header'><strong>${tituloIniciativa}</strong></h5>
                        <div class='card-body ios-body'>
                            <div class='text-center mb-2'>
                                <img src='${iniciativa.imagen}' alt='Imagen de iniciativa' class='img-fluid'>
                            </div>
                            <p class='card-text ios-text'><strong>Descripción: </strong>${iniciativa.descripcion}</p>
                            <p class='card-text ios-text m-0'><strong>Fecha: </strong>${iniciativa.fecha}</p>
                            <p class='card-text ios-text m-0'><strong>Departamento: </strong>${iniciativa.departamento}</p>
                            <div class='d-flex align-items-center mb-2'>
                                <p class='card-text ios-text m-0'><strong>Usuario: </strong></p>
                                <div class='avatar-group ms-2 d-flex align-items-center'>
                                    <div data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' title='${iniciativa.usuario}'>
                                        <img src='${iniciativa.usuario_img}' alt='Avatar' class='rounded-circle'>
                                    </div>
                                    <span class='ms-1'>${iniciativa.usuario}</span>
                                </div>
                            </div>
                            <p class='card-text ios-text'>
                                <strong>Estado: </strong>
                                <span class='badge ${iniciativa.estado === 'Aprobada' ? 'bg-success' : 'bg-danger'}'>
                                    ${iniciativa.estado}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            `;

            // Agregar el HTML de la iniciativa al contenedor
            iniciativasContainer.innerHTML += iniciativaHtml;
        });

        // Script para capturar el título de la iniciativa al abrir el modal de eliminación
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var tituloIniciativa = button.data('titulo');
            $('#modalTituloIniciativa').text(tituloIniciativa);
        });

        // Script para manejar la eliminación cuando se hace clic en el botón dentro del modal de eliminación
        $('#eliminarIniciativaBtn').on('click', function () {
            // Aquí puedes agregar la lógica para manejar la eliminación de la iniciativa
        });

        // Script para capturar la información al abrir el modal de edición
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var tituloIniciativa = button.data('titulo');
            var estadoIniciativa = button.data('status');

            // Actualiza el contenido del modal con la información de la iniciativa
            $('#editModalLabel').text('Editar Iniciativa: ' + tituloIniciativa);
            $('#tituloIniciativa').val(tituloIniciativa);
            $('#estadoIniciativa').val(estadoIniciativa);
        });

        // Script para manejar la edición cuando se hace clic en el botón dentro del modal
        $('#guardarCambiosBtn').on('click', function () {
            // Aquí puedes agregar la lógica para manejar la edición de la iniciativa
        });
    </script>

  <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>

   
    <!-- Page JS -->
    <script src="../../assets/js/form-layouts.js"></script>
    <script src="../../assets/js/form-wizard-numbered.js"></script>
    <script src="../../assets/js/form-wizard-validation.js"></script>

@endsection