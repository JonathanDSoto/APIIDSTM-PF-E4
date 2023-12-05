@extends('panel/panel_layout')

@section('title', 'Reporte')
@section('content-size', 'xxl')

@section('aditional_header')
    
@endsection

@section('aditional_scripts')


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
    
    <!-- Row Group CSS -->
  <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">

 
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">UBACS</span> Reportes
    </h4>

    <!-- Sección de Reportes -->
    <div class="row" id="reportes-container">
        <!-- Contenedor de reportes generado dinámicamente con JavaScript -->
    </div>

    <script>
        // Función para obtener la clase del distintivo según el estado
        function getBadgeClass(estado) {
            switch (estado) {
                case 'Completado':
                    return 'bg-success';
                case 'Descartado':
                    return 'bg-danger';
                case 'En Revisión':
                    return 'bg-warning';
                default:
                    return 'bg-secondary';
            }
        }

        // Array de reportes
        var reportes = [
            ['Nombre del Reporte 1', 'Descripción del reporte 1', 'En Revisión', 'NombreUsuario1', '2023-01-01', 'Departamento1'],
            ['Nombre del Reporte 2', 'Descripción del reporte 2', 'Completado', 'NombreUsuario2', '2023-02-15', 'Departamento2'],
            ['Nombre del Reporte 3', 'Descripción del reporte 3', 'Descartado', 'NombreUsuario3', '2023-03-20', 'Departamento3'],
        ];

        // Obtener el contenedor de reportes
        var reportesContainer = document.getElementById('reportes-container');

        // Iterar sobre los reportes
        reportes.forEach(function (reporte, id) {
            var [nombre, descripcion, estado, nombreUsuario, fecha, departamento] = reporte;
            var id_modal_editar = 'editarModal' + id;
            var id_modal_eliminar = 'eliminarModal' + id;

            // Generar código HTML para cada reporte
            var reporteHtml = `
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <div class='card-header'>
                            <h5 class='card-title mb-0'>$nombre</h5>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item'><strong>Reporte:</strong> $descripcion</li>
                            <li class='list-group-item d-flex align-items-center'>
                                <strong>Usuario:</strong>
                                <div class='avatar-group ms-2 d-flex align-items-center'>
                                    <div data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' title='$nombreUsuario'>
                                        <img src='../../assets/img/avatars/5.png' alt='Avatar' class='rounded-circle'>
                                    </div>
                                    <span class='ms-1'>$nombreUsuario</span>
                                </div>
                            </li>
                            <li class='list-group-item'>
                                <strong>Fecha:</strong> $fecha
                            </li>
                            <li class='list-group-item'>
                                <strong>Departamento:</strong> $departamento
                            </li>
                            <li class='list-group-item'>
                                <strong>Estado:</strong>
                                <span class='badge ${getBadgeClass(estado)}'>$estado</span>
                            </li>
                            <li class='list-group-item'>
                                <div class='d-grid gap-2'>
                                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#${id_modal_editar}'>
                                        <i class='fas fa-edit me-2'></i> Editar
                                    </button>
                                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#${id_modal_eliminar}'>
                                        <i class='fas fa-trash-alt me-2'></i> Eliminar
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Modal Editar -->
                <div class='modal fade' id='${id_modal_editar}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Editar Reporte</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <!-- Mostrar todos los detalles del reporte, permitir editar el estado -->
                                <form>
                                    <div class='mb-3'>
                                        <label for='nombre$id' class='form-label'>Nombre del Reporte</label>
                                        <input type='text' class='form-control' id='nombre$id' value='$nombre' disabled>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='descripcion$id' class='form-label'>Descripción del Reporte</label>
                                        <textarea class='form-control' id='descripcion$id' rows='3' disabled>$descripcion</textarea>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='usuario$id' class='form-label'>Usuario</label>
                                        <input type='text' class='form-control' id='usuario$id' value='$nombreUsuario' disabled>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='fecha$id' class='form-label'>Fecha</label>
                                        <input type='text' class='form-control' id='fecha$id' value='$fecha' disabled>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='departamento$id' class='form-label'>Departamento</label>
                                        <input type='text' class='form-control' id='departamento$id' value='$departamento' disabled>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='estado${id}' class='form-label'>Estado</label>
                                        <select class='form-select' id='estado${id}'>
                                            <option value='En Revisión' ${estado === 'En Revisión' ? 'selected' : ''}>En Revisión</option>
                                            <option value='Completado' ${estado === 'Completado' ? 'selected' : ''}>Completado</option>
                                            <option value='Descartado' ${estado === 'Descartado' ? 'selected' : ''}>Descartado</option>
                                            <!-- Agrega más opciones según tus necesidades -->
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-primary'>
                                    <i class='ti ti-check me'></i>Guardar Cambios
                                </button>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Eliminar -->
                <div class='modal fade' id='${id_modal_eliminar}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Eliminar Reporte</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <p>¿Está seguro de que desea eliminar el reporte '$nombre'?</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                <button type='button' class='btn btn-danger'>
                                  <i class='ti ti-trash me'></i>Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Agregar el HTML del reporte al contenedor
            reportesContainer.innerHTML += reporteHtml;
        });

        // Función para guardar cambios (puedes personalizar según tus necesidades)
        function guardarCambios(id) {
            // Obtener el valor del estado seleccionado
            var nuevoEstado = document.getElementById('estado' + id).value;
            
            // Aquí puedes realizar acciones adicionales según tus necesidades, como enviar datos al servidor, etc.
            
            // Cerrar el modal
            $('#editarModal' + id).modal('hide');
        }
        // Función para eliminar un reporte (puedes personalizar según tus necesidades)
        function eliminarReporte(id) {
            // Aquí puedes realizar acciones adicionales según tus necesidades, como enviar datos al servidor, etc.
            
            // Cerrar el modal
            $('#eliminarModal' + id).modal('hide');
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

   
    <!-- Page JS -->
    <script src="../../assets/js/form-layouts.js"></script>
    <script src="../../assets/js/form-wizard-numbered.js"></script>
    <script src="../../assets/js/form-wizard-validation.js"></script>
@endsection
