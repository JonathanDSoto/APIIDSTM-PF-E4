@extends('panel/panel_layout')

@section('title', 'Calendario')
@section('content-size', 'xxl')

@section('aditional_header')
    <!-- Agrega la hoja de estilo de FullCalendar -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/css/fullcalendar.min.css') }}" />
    <!-- Agrega el tema Bootstrap para FullCalendar -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/css/bootstrap/main.min.css') }}" />
@endsection

@section('aditional_scripts')
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- <script src="../../assets/js/ui-modals.js"></script> -->

    <!-- Agrega los scripts de FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3"></script>
    <script src="../../assets/js/app-calendar-events.js"></script>
    <script src="../../assets/js/app-calendar.js"></script>

    <script src="../../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <link rel="stylesheet" href="../../assets/vendor/libs/swiper/swiper.css" />

     <!-- Page CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/app-calendar.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/pages/ui-carousel.css" />

@endsection

@section('content')
<!-- Multiple slides -->
<div class="col-12 mb-4">
    <h6 class="text-muted mt-3">Próximos Eventos</h6>
    <div class="swiper" id="swiper-multiple-slides">
      <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image:url(../../assets/img/elements/10.jpg)">Evento</div>
        <div class="swiper-slide" style="background-image:url(../../assets/img/elements/14.jpg)">Evento</div>
        <div class="swiper-slide" style="background-image:url(../../assets/img/elements/13.jpg)">Evento</div>
        <div class="swiper-slide" style="background-image:url(../../assets/img/elements/7.jpg)">Evento</div>
        <div class="swiper-slide" style="background-image:url(../../assets/img/elements/15.jpg)">Evento</div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>

<div class="card app-calendar-wrapper">
  <div class="row g-0">
    <!-- Calendar Sidebar -->
    <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
      <div class="border-bottom p-4 my-sm-0 mb-3">
        <div class="d-grid">
          <button class="btn btn-primary btn-toggle-sidebar" data-bs-toggle="offcanvas" data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">Agregar Evento</span>
          </button>
        </div>
      </div>
      <div class="p-3">
        <!-- inline calendar (flatpicker) -->
        <div class="inline-calendar"></div>

        <hr class="container-m-nx mb-4 mt-3">

        <!-- Filter -->
        <div class="mb-3 ms-3">
          <small class="text-small text-muted text-uppercase align-middle">Filter</small>
        </div>

        <div class="form-check mb-2 ms-3">
          <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all" checked>
          <label class="form-check-label" for="selectAll">Todos</label>
        </div>

        <div class="app-calendar-events-filter ms-3">
          <div class="form-check form-check-danger mb-2">
            <input class="form-check-input input-filter" type="checkbox" id="select-personal" data-value="deportivos" checked>
            <label class="form-check-label" for="select-personal">Eventos Deportivos</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input input-filter" type="checkbox" id="select-business" data-value="culturales" checked>
            <label class="form-check-label" for="select-business">Eventos Culturales</label>
          </div>
          <div class="form-check form-check-warning mb-2">
            <input class="form-check-input input-filter" type="checkbox" id="select-family" data-value="feria" checked>
            <label class="form-check-label" for="select-family">Ferias</label>
          </div>
          <div class="form-check form-check-success mb-2">
            <input class="form-check-input input-filter" type="checkbox" id="select-holiday" data-value="consejo" checked>
            <label class="form-check-label" for="select-holiday">Consejo</label>
          </div>
          <div class="form-check form-check-info">
            <input class="form-check-input input-filter" type="checkbox" id="select-etc" data-value="festivos" checked>
            <label class="form-check-label" for="select-etc">Festivos</label>
          </div>
        </div>
      </div>
    </div>
  <!-- /Calendar Sidebar -->

  <!-- Calendar & Modal -->
    <div class="col app-calendar-content">
      <div class="card shadow-none border-0">
        <div class="card-body pb-0">
          <!-- FullCalendar -->
          <div id="calendar"></div>
        </div>
      </div>
    <div class="app-overlay"></div>

  <!-- FullCalendar Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEventModalLabel">Agregar Evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">
          <form class="event-form pt-0" id="eventForm" onsubmit="return false">
            <div class="mb-3">
              <label class="form-label" for="eventTitle">Titulo</label>
              <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Event Title" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventLabel">Tipo</label>
              <select class="select2 select-event-label form-select" id="eventLabel" name="eventLabel">
                <option data-label="primary" value="Deportivos" selected>Eventos Deportivos</option>
                <option data-label="danger" value="Culturales">Eventos Culturales</option>
                <option data-label="warning" value="Feria">Ferias</option>
                <option data-label="success" value="Consejo">Consejo</option>
                <option data-label="info" value="Festivos">Festivos</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventStartDate">Fecha Inicio</label>
              <input type="text" class="form-control" id="eventStartDate" name="eventStartDate" placeholder="Start Date" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventEndDate">Fecha Fin</label>
              <input type="text" class="form-control" id="eventEndDate" name="eventEndDate" placeholder="End Date" />
            </div>
            <div class="mb-3">
              <label class="switch">
                <input type="checkbox" class="switch-input allDay-switch" />
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label">Todo el día</span>
              </label>
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventURL">Evento URL</label>
              <input type="url" class="form-control" id="eventURL" name="eventURL" placeholder="https://www.google.com" />
            </div>
            <div class="mb-3 select2-primary">
              <label class="form-label" for="eventGuests">Agregar Invitados</label>
              <select class="select2 select-event-guests form-select" id="eventGuests" name="eventGuests" multiple>
                <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventLocation">Ubicación</label>
              <input type="text" class="form-control" id="eventLocation" name="eventLocation" placeholder="Enter Location" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="eventDescription">Descripción</label>
              <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
            </div>
            <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
              <div>
                <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Agregar</button>
                <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">Cancelar</button>
              </div>
              <div><button class="btn btn-label-danger btn-delete-event d-none">Eliminar</button></div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Calendar & Modal -->
  </div>
</div>



  <!-- Vendors JS -->
  <script src="../../assets/vendor/libs/swiper/swiper.js"></script>
   <!-- Page JS -->
   <script src="../../assets/js/ui-carousel.js"></script>
@endsection
