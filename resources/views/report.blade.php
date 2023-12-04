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

  <style>
    .card {
        background-color: #f8f9fa; /* Cambia este color al que prefieras */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Agrega una sombra suave */
    }

    .badge {
        border-radius: 4px; /* Bordes redondeados para los distintivos */
    }
</style>
@endsection

@section('content')            
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">UBACS</span> Reportes
</h4>
 
<!-- Sección de Reportes -->
<div class="container mt-2">
    <div class="row">
      <?php
        // Función para obtener la clase del distintivo según el estado
        function getBadgeClass($estado) {
            switch ($estado) {
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
        $reportes = [
            ['Nombre del Reporte 1', 'Descripción del reporte 1', 'En Revisión', 'NombreUsuario1', '2023-01-01', 'Departamento1'],
            ['Nombre del Reporte 2', 'Descripción del reporte 2', 'Completado', 'NombreUsuario2', '2023-02-15', 'Departamento2'],
            ['Nombre del Reporte 3', 'Descripción del reporte 3', 'Descartado', 'NombreUsuario3', '2023-03-20', 'Departamento3'],
        ];

        // Iterar sobre los reportes
        foreach ($reportes as $id => $reporte) {
            $nombre = $reporte[0];
            $descripcion = $reporte[1];
            $estado = $reporte[2];
            $nombreUsuario = $reporte[3];
            $fecha = $reporte[4];
            $departamento = $reporte[5];

            $id_modal_editar = 'editarModal' . $id;
            $id_modal_eliminar = 'eliminarModal' . $id;

            // Generar código HTML para cada reporte
            echo "
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
                                <span class='badge " . getBadgeClass($estado) . "'>$estado</span>
                            </li>
                            <li class='list-group-item'>
                                <div class='d-grid gap-2'>
                                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#$id_modal_editar'>
                                        <i class='fas fa-edit me-2'></i> Editar
                                    </button>
                                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#$id_modal_eliminar'>
                                        <i class='fas fa-trash-alt me-2'></i> Eliminar
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Modal Editar -->
                <div class='modal fade' id='$id_modal_editar' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                                        <input type='text' class='form-control' id='nombre$id' value='$nombre' readonly>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='descripcion$id' class='form-label'>Descripción del Reporte</label>
                                        <textarea class='form-control' id='descripcion$id' rows='3' readonly>$descripcion</textarea>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='usuario$id' class='form-label'>Usuario</label>
                                        <input type='text' class='form-control' id='usuario$id' value='$nombreUsuario' readonly>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='fecha$id' class='form-label'>Fecha</label>
                                        <input type='text' class='form-control' id='fecha$id' value='$fecha' readonly>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='departamento$id' class='form-label'>Departamento</label>
                                        <input type='text' class='form-control' id='departamento$id' value='$departamento' readonly>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='estado$id' class='form-label'>Estado</label>
                                        <input type='text' class='form-control' id='estado$id' value='$estado'>
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-primary'>Guardar Cambios</button>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Eliminar -->
                <div class='modal fade' id='$id_modal_eliminar' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
            ";
        }
      ?>
    </div>
</div>


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
