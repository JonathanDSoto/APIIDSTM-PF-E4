@extends('panel/panel_layout')

@section('title', 'Materias')
@section('content-size', 'xxl')

@section('aditional_header')

@endsection

@section('aditional_scripts')
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

<script src="../../assets/js/Dashboard/Dashboard-main.js"></script>
<script>
    let user_name_label = document.getElementById('user_name_label');
    user_name_label.textContent = window.user_info.name;
</script>



<script>
    async function fetchDataIniciatives() {
        try {
            const response = await fetch(`${window.location.origin}/api/initiative`);
            const data = await response.json();

            const numeroDeRegistros = Array.isArray(data) ? data.length : 0;

            const miElemento = document.getElementById('totalIni');

            miElemento.textContent = `${numeroDeRegistros}`;

        } catch (error) {
            console.error('Error al obtener o procesar los datos:', error);
        }
    }

    fetchDataIniciatives();

    async function fetchDataDept() {
        try {

            const response = await fetch(`${window.location.origin}/api/department`);
            const data = await response.json();

            const numeroDeRegistrosDept = Array.isArray(data) ? data.length : 0;

            const miElemento = document.getElementById('totalDept');

            miElemento.textContent = `${numeroDeRegistrosDept}`;

        } catch (error) {
            console.error('Error al obtener o procesar los datos:', error);
        }
    }


    fetchDataDept();

    async function fetchDataReports() {
        try {
            const response = await fetch(`${window.location.origin}/api/reports`);
            const data = await response.json();

            const numeroDeRegistrosRepor = Array.isArray(data) ? data.length : 0;

            const miElemento = document.getElementById('totalReport');
            const miElemento2 = document.getElementById('totalReportes');

            miElemento.textContent = `${numeroDeRegistrosRepor}`;

            miElemento2.textContent = numeroDeRegistrosRepor > 1 
                ? `${numeroDeRegistrosRepor} reportes`
                : `${numeroDeRegistrosRepor} reporte`

            return miElemento2;
        } catch (error) {
            console.error('Error al obtener o procesar los datos:', error);
        }
    }

    fetchDataReports();


    document.addEventListener("DOMContentLoaded", function () {
        const leadsReportChart = document.querySelector("#leadsReportChart");

        if (leadsReportChart) {
            const chartData = {
                chart: {
                    height: 200,
                    width: 250,
                    parentHeightOffset: 0,
                    type: "donut",
                },
                labels: ["Aprobadas", "En revisión", "Descartados"],
                series: [0, 0, 0],
            };

            const chart = new ApexCharts(leadsReportChart, chartData);

            chart.render();

            fetch(`${window.location.origin}/api/reports`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error al hacer la solicitud: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    contarYActualizarGrafica(data, chart);
                })
                .catch(error => {
                    console.error('Error al obtener datos de la API:', error);
                });
        }
    });

    function contarYActualizarGrafica(data, chart) {
        let completadoCount = 0;
        let pendienteCount = 0;
        let descartadoCount = 0;

        

        data.forEach(item => {
            const status = item.status;

            if (status === 'completado') {
                completadoCount++;
            } else if (status === 'en revisión') {
                pendienteCount++;
            } else if (status === "descartado") {
                descartadoCount++;
            }
        });

        chart.updateOptions({
            series: [completadoCount, pendienteCount, descartadoCount],
        });
    }

    async function construirDatosParaGrafico() {
    const numeroDeRegistrosRepor = await fetchReportData();

    return {
        labels: ['Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May'],
        datasets: [
            {
                label: 'Reportes',
                data: [numeroDeRegistrosRepor, 0, 0, 0, 0, 0],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            },
            
        ],
    };
}
    
    var datos = {
        labels: ['Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May'],
        datasets: [{
            label: 'Reportes',
            data: [5, 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
        {
            label: 'Iniciativas',
            data: [1, 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'Departamentos',
            data: [1, 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(223, 93, 4, 0.2)',
            borderColor: 'rgba(223, 93, 4, 1)',
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

</script>

<script>



</script>
@endsection

@section('aditional_css')
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

@endsection



@section('content')
{{-- <h2 class="mb-4">Dashboard</h2> --}}
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3>Bienvenid@ de nuevo, <span id="user_name_label"></span>👋🏻</h3>
            <div class="col-12 col-lg-7">
                <p>¡Aqui puedes ver un resumen de la informacion registrada!</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                    <span class="bg-label-primary p-2 rounded">
                        <i class='ti ti-device-laptop ti-xl'></i>
                    </span>
                    <div class="content-right">
                        <p class="mb-0">Total de reportes</p>
                        <h4 class="text-primary mb-0" id="totalReport"></h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="bg-label-info p-2 rounded">
                        <i class='ti ti-bulb ti-xl'></i>
                    </span>
                    <div class="content-right">
                        <p class="mb-0">Total de iniciativas</p>
                        <h4 class="text-info mb-0" id="totalIni"></h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="bg-label-warning p-2 rounded">
                        <i class='ti ti-discount-check ti-xl'></i>
                    </span>
                    <div class="content-right">
                        <p class="mb-0">Total de departamentos</p>
                        <h4 class="text-warning mb-0" id="totalDept"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>
                        <h5 class="mb-2">Proporción del estado de reportes</h5>
                        <p class="mb-5">Registro total</p>
                    </div>
                    <div class="time-spending-chart">
                        <h3 class="mb-2" id="totalReportes"> <span class="text-muted"></span>
                        </h3>
                        {{-- <span class="badge bg-label-success">+18.4%</span> --}}
                    </div>
                </div>
                <div id="leadsReportChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Topic and Instructors -->
<div class="row mb-4 g-4">
    <div class="col-12 col-xl-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Departamentos con mas reportes</h5>
                {{-- <div class="dropdown">
                    <button class="btn p-0" type="button" id="topic" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topic">
                        <a class="dropdown-item" href="javascript:void(0);">Highest Views</a>
                        <a class="dropdown-item" href="javascript:void(0);">See All</a>
                    </div>
                </div> --}}
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <div id="horizontalBarChart"></div>
                </div>
                <div class="col-md-6 d-flex justify-content-around align-items-center">
                    <div>
                        <div class="d-flex align-items-baseline">
                            <span class="text-primary me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">UI Design</p>
                                <h5>35%</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline my-3">
                            <span class="text-success me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">Music</p>
                                <h5>14%</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <span class="text-danger me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">React</p>
                                <h5>10%</h5>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex align-items-baseline">
                            <span class="text-info me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">UX Design</p>
                                <h5>20%</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline my-3">
                            <span class="text-secondary me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">Animation</p>
                                <h5>12%</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <span class="text-warning me-2"><i class='ti ti-circle-filled fs-6'></i></span>
                            <div>
                                <p class="mb-2">SEO</p>
                                <h5>9%</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-5 col-g-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Reportes e Iniciativas a lo largo del tiempo</h5>
                <canvas id="reportesIniciativasChart" width="100%" height="60%"></canvas>
            </div>
        </div>
    </div>

    {{-- <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Popular Instructors</h5>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="popularInstructors" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="popularInstructors">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless border-top">
                    <thead class="border-bottom">
                        <tr>
                            <th>Instructors</th>
                            <th class="text-end">courses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Maven Analytics</h6>
                                        <small class="text-truncate text-muted">Business Intelligence</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                    <p class="mb-0 fw-medium">33</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Zsazsa McCleverty</h6>
                                        <small class="text-truncate text-muted">Digital Marketing</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">52</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="../../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Nathan Wagner</h6>
                                        <small class="text-truncate text-muted">UI/UX Design</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">12</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="../../assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Emma Bowen</h6>
                                        <small class="text-truncate text-muted">React Native</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">8</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}


    {{-- <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Top Courses</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="topCourses" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topCourses">
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Download</a>
                        <a class="dropdown-item" href="javascript:void(0);">View All</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex mb-4 pb-1 align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-video ti-md"></i></span>
                        </div>
                        <div class="row w-100 align-items-center">
                            <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                                <p class="mb-0 fw-medium">Videography Basic Design Course</p>
                            </div>
                            <div
                                class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-sm-end justify-content-md-start justify-content-xxl-end">
                                <div class="badge bg-label-secondary">1.2k Views</div>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1 align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="ti ti-code ti-md"></i></span>
                        </div>
                        <div class="row w-100 align-items-center">
                            <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                                <p class="mb-0 fw-medium">Basic Front-end Development Course</p>
                            </div>
                            <div
                                class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-sm-end justify-content-md-start justify-content-xxl-end">
                                <div class="badge bg-label-secondary">834 Views</div>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1 align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="ti ti-camera ti-md"></i></span>
                        </div>
                        <div class="row w-100 align-items-center">
                            <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                                <p class="mb-0 fw-medium">Basic Fundamentals of Photography</p>
                            </div>
                            <div
                                class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-sm-end justify-content-md-start justify-content-xxl-end">
                                <div class="badge bg-label-secondary">3.7k Views</div>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1 align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="ti ti-brand-dribbble ti-md"></i></span>
                        </div>
                        <div class="row w-100 align-items-center">
                            <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                                <p class="mb-0 fw-medium">Advance Dribble Base Visual Design</p>
                            </div>
                            <div
                                class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-sm-end justify-content-md-start justify-content-xxl-end">
                                <div class="badge bg-label-secondary">2.5k Views</div>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger"><i
                                    class="ti ti-microphone-2 ti-md"></i></span>
                        </div>
                        <div class="row w-100 align-items-center">
                            <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                                <p class="mb-0 fw-medium">Your First Singing Lesson</p>
                            </div>
                            <div
                                class="col-sm-4 col-lg-12 col-xxl-4 d-flex justify-content-sm-end justify-content-md-start justify-content-xxl-end">
                                <div class="badge bg-label-secondary">948 Views</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}


    {{-- <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                    <img class="img-fluid" src="../../assets/img/illustrations/girl-with-laptop.png"
                        alt="Card girl image" width="140" />
                </div>
                <h4 class="mb-2 pb-1">Upcoming Webinar</h4>
                <p class="small">Next Generation Frontend Architecture Using Layout Engine And React Native Web.
                </p>
                <div class="row mb-3 g-3">
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="ti ti-calendar-event ti-md"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0 text-nowrap">17 Nov 23</h6>
                                <small>Date</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="avatar flex-shrink-0 me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="ti ti-clock ti-md"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0 text-nowrap">32 minutes</h6>
                                <small>Duration</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary w-100">Join the event</a>
            </div>
        </div>
    </div> --}}


    {{-- <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Assignment Progress</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex mb-3 pb-1">
                        <div class="chart-progress me-3" data-color="primary" data-series="72"
                            data-progress_variant="true"></div>
                        <div class="row w-100 align-items-center">
                            <div class="col-9">
                                <div class="me-2">
                                    <h6 class="mb-2">User experience Design</h6>
                                    <small>120 Tasks</small>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
                                    <i class="ti ti-chevron-right scaleX-n1-rtl"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-3 pb-1">
                        <div class="chart-progress me-3" data-color="success" data-series="48"
                            data-progress_variant="true"></div>
                        <div class="row w-100 align-items-center">
                            <div class="col-9">
                                <div class="me-2">
                                    <h6 class="mb-2">Basic fundamentals</h6>
                                    <small>32 Tasks</small>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
                                    <i class="ti ti-chevron-right scaleX-n1-rtl"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-3 pb-1">
                        <div class="chart-progress me-3" data-color="danger" data-series="15"
                            data-progress_variant="true"></div>
                        <div class="row w-100 align-items-center">
                            <div class="col-9">
                                <div class="me-2">
                                    <h6 class="mb-2">React native components</h6>
                                    <small>182 Tasks</small>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
                                    <i class="ti ti-chevron-right scaleX-n1-rtl"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="chart-progress me-3" data-color="info" data-series="24"
                            data-progress_variant="true"></div>
                        <div class="row w-100 align-items-center">
                            <div class="col-9">
                                <div class="me-2">
                                    <h6 class="mb-2">Basic of music theory</h6>
                                    <small>56 Tasks</small>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-label-secondary">
                                    <i class="ti ti-chevron-right scaleX-n1-rtl"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}

</div>
<!--  Topic and Instructors  End-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@endsection