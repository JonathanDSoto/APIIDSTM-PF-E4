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

<?php
$iniciativas = [
    ['titulo' => 'Angular Project', 'descripcion' => 'Breve descripción del proyecto...', 'usuario' => 'Usuario 1',
     'estado' => 'Aprobada', 'imagen' => '../../assets/img/elements/10.jpg', 'usuario_img' => '../../assets/img/avatars/5.png'],
    ['titulo' => 'Validar Horarios', 'descripcion' => 'Breve descripción del proyecto...', 'usuario' => 'Usuario 2',
    'estado'=> 'Aprobada', 'imagen' => '../../assets/img/elements/12.jpg', 'usuario_img' => '../../assets/img/avatars/6.png'],
    ['titulo' => 'Limpiar Baños', 'descripcion' => 'Breve descripción del proyecto...', 'usuario' => 'Usuario 3',
    'estado'=> 'Aprobada', 'imagen' => '../../assets/img/elements/13.jpg', 'usuario_img' => '../../assets/img/avatars/7.png']
  ];
?>

<!-- Sección de Iniciativas -->
<div class="row">
    <?php foreach ($iniciativas as $iniciativa) : ?>
        <div class="col-md-4 mb-4">
            <div class="card ios-card position-relative">
                <div class="position-absolute top-0 end-0 m-4">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-outline-danger delete-button">
                        <i class="ti ti-trash me"></i>
                    </button>
                </div>

                <h5 class="card-header ios-header"><strong><?php echo $iniciativa['titulo']; ?></strong></h5>
                <div class="card-body ios-body">
                    <div class="text-center mb-2">
                        <img src="<?php echo $iniciativa['imagen']; ?>" alt="Imagen de iniciativa" class="img-fluid">
                    </div>
                    <p class="card-text ios-text"><strong>Descripción: </strong><?php echo $iniciativa['descripcion']; ?></p>
                    <div class="d-flex align-items-center mb-2">
                        <p class="card-text ios-text me-2"><strong>Usuario: </strong></p>
                        <img src="<?php echo $iniciativa['usuario_img']; ?>" alt="Avatar" class="rounded-circle m-2" style="width: 32px; height: 32px;">
                        <p><?php echo $iniciativa['usuario']; ?></p>
                    </div>
                    <p class="card-text ios-text"><strong>Estado: </strong> <span class="badge bg-label-primary"><?php echo $iniciativa['estado']; ?></span></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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
          ¿Estás seguro de que deseas eliminar esta iniciativa?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <!-- Agregamos el botón de eliminar con el ícono de bote de basura -->
          <button type="button" class="btn btn-danger">
            <i class="bi bi-trash"></i> Eliminar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

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