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
    <div class="container-fluid">
        <h2 class="mb-4">Dashboard</h2>

        <div class="row">
            <!-- Gráfico de Reportes e Iniciativas a lo largo del tiempo -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reportes e Iniciativas a lo largo del tiempo</h5>
                        <canvas id="reportesIniciativasChart" width="300" height="150"></canvas>
                    </div>
                </div>
            </div>

             <!-- Gráfico Lineal para Reportes e Iniciativas No Aprobadas -->
             <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reportes e Iniciativas No Aprobadas</h5>
                        <canvas id="noAprobadasChart" width="300" height="150"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Pastel para Reportes e Iniciativas Aprobadas -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reportes e Iniciativas Aprobadas</h5>
                        <canvas id="aprobadasChart" width="100" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Total de Reportes -->
            <div class="col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Reportes</h5>
                        <p class="card-text">123</p>
                    </div>
                </div>
            </div>

            <!-- Total de Iniciativas -->
            <div class="col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Iniciativas</h5>
                        <p class="card-text">45</p>
                    </div>
                </div>
            </div>

            <!-- Total de Edificios -->
            <div class="col-md-2 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Edificios</h5>
                        <p class="card-text">20</p>
                    </div>
                </div>
            </div>

            <!-- Total de Departamentos -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Departamentos</h5>
                        <p class="card-text">80</p>
                    </div>
                </div>
            </div>

            <!-- Total de Materias -->
            <div class="col-md-2 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Materias</h5>
                        <p class="card-text">150</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <script>
        // Datos de ejemplo para el gráfico
        var datos = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Reportes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Iniciativas',
                    data: [8, 7, 2, 8, 4, 6],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        };

        // Configuración del gráfico
        var opciones = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Obtén el contexto del canvas y crea el gráfico
        var contexto = document.getElementById('reportesIniciativasChart').getContext('2d');
        var reportesIniciativasChart = new Chart(contexto, {
            type: 'bar',
            data: datos,
            options: opciones
        });

        // Espera a que la página se cargue completamente
        $(document).ready(function () {
            // Datos de ejemplo para el gráfico de pastel de Aprobadas
            var datosAprobadas = {
                labels: ['Aprobadas', 'No Aprobadas'],
                datasets: [
                    {
                        data: [30, 5],
                        backgroundColor: ['#36A2EB', '#FFCE56'],
                    },
                ],
            };

            // Configuración del gráfico de pastel de Aprobadas
            var opcionesAprobadas = {};

            // Obtén el contexto del canvas y crea el gráfico de pastel de Aprobadas
            var contextoAprobadas = document.getElementById('aprobadasChart').getContext('2d');
            var aprobadasChart = new Chart(contextoAprobadas, {
                type: 'pie',
                data: datosAprobadas,
                options: opcionesAprobadas,
            });

            // Datos de ejemplo para el gráfico lineal de No Aprobadas
            var datosNoAprobadas = {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'No Aprobadas',
                        data: [2, 1, 0, 3, 1, 4],
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                ],
            };

            // Configuración del gráfico lineal de No Aprobadas
            var opcionesNoAprobadas = {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            };

            // Obtén el contexto del canvas y crea el gráfico lineal de No Aprobadas
            var contextoNoAprobadas = document.getElementById('noAprobadasChart').getContext('2d');
            var noAprobadasChart = new Chart(contextoNoAprobadas, {
                type: 'line',
                data: datosNoAprobadas,
                options: opcionesNoAprobadas,
            });
        });
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
