@extends('panel/panel_layout')

@section('title', 'Reporte')
@section('content-size', 'xxl')

@section('aditional_header')

@endsection

@section('aditional_css')

@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">UABCS/</span> Reportes
    </h4>

    <!-- Sección de Reportes -->
    <div class="row" id="reportes-container">
        <!-- Contenedor de reportes generado dinámicamente con JavaScript -->
    </div>

    <!-- Modal Editar -->
    <div class='modal fade' id="editarModal" tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                            <label for='title' class='form-label'>Nombre del Reporte</label>
                            <input type='text' class='form-control' id='title' value='' disabled>
                        </div>
                        <div class='mb-3'>
                            <label for='descripcion' class='form-label'>Descripción del Reporte</label>
                            <textarea class='form-control' id='descripcion' rows='3' disabled></textarea>
                        </div>
                        <div class='mb-3'>
                            <label for='edificio' class='form-label'>Edificio</label>
                            <select class='form-select' id='edificio' disabled>

                            </select>
                            {{-- <input type='text' class='form-control' id='edificio' value='edificio' disabled> --}}
                        </div>
                        <div class='mb-3'>
                            <label for='estado' class='form-label'>Estado</label>
                            <select class='form-select' id='estado'>
                                <option value="completado">Completado</option>
                                <option value="descartado">Descartado</option>
                                <option value="en revisión">En Revisión</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button id="saveBtn" type='button' class='btn btn-primary'>
                        <i class='ti ti-check me'></i>Guardar Cambios
                    </button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('aditional_scripts')
    <script>
        const titulo = document.getElementById('title');
        const descripcion = document.getElementById('descripcion');
        const edificio = document.getElementById('edificio');
        const estado = document.getElementById('estado');
        const guardarBtn = document.getElementById('saveBtn');

        // Obtener el contenedor de reportes
        const reportesContainer = document.getElementById('reportes-container');

        async function mostrarReportes() {
            reportesContainer.innerHTML = "";

            const getDate = (date) => {
                // Función para agregar ceros a la izquierda
                const padLeft = (value, length) => {
                    return String(value).padStart(length, '0');
                };

                const fecha = new Date(date);
                const dia = fecha.getDate();
                const mes = fecha.getMonth() + 1;
                const año = fecha.getFullYear();
                const horas = padLeft(fecha.getHours(), 2); // Agrega cero a la izquierda si es necesario
                const minutos = padLeft(fecha.getMinutes(), 2); // Agrega cero a la izquierda si es necesario
                const segundos = padLeft(fecha.getSeconds(), 2); // Agrega cero a la izquierda si es necesario

                return `${dia}/${mes}/${año} ${horas}:${minutos}:${segundos}`;
            }

            const badgeClass = {
                'completado': 'bg-success',
                'descartado': 'bg-danger',
                'en revisión': 'bg-warning',
            };
            const getBadge = (status) => badgeClass[status] ?? 'bg-secondary';


            const request = await fetch(`${window.location.origin}/api/reports`);
            let reportes;

            if (request.status != 200) {
                Swal.fire({
                    title: "¡Hubo un problema! :(",
                    text: "No pudo ser posible cargar los reportes. Intentelo de nuevo",
                    icon: "error"
                });
                return;
            }

            reportes = await request.json();
            if (!reportes) {
                Swal.fire({
                    title: "No hay reportes registrados",
                    text: "El sistema no titne reportes registrados",
                    icon: "error"
                });
                return;
            }


            // Iterar sobre los reportes
            reportes.forEach((reporte) => {
                reporte.status = reporte.status[0].toUpperCase() + reporte.status.slice(1);
                // Generar código HTML para cada reporte
                var reporteHtml = `
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <div class='card-header'>
                            <h5 class='card-title mb-0'> ${reporte.title} </h5>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item'><strong>Descripción:</strong> ${reporte.description}</li>
                            <li class='list-group-item d-flex align-items-center'>
                                <strong>Usuario:</strong>
                                <div class='avatar-group ms-2 d-flex align-items-center'>
                                    <div data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' title='$nombreUsuario'>
                                        <img src='https://ui-avatars.com/api/?name=${reporte.user.name}+${reporte.user.lastname}' alt='Avatar' class='rounded-circle'>
                                    </div>
                                    <span class='ms-1'>${reporte.user.name}</span>
                                </div>
                            </li>
                            <li class='list-group-item'>
                                <strong>Fecha:</strong> ${getDate(reporte.created_at)}
                            </li>
                            <li class='list-group-item'>
                                <strong>Id del edificio:</strong> ${reporte.building.name}
                            </li>
                            <li class='list-group-item'>
                                <strong>Estado:</strong>
                                <span class='badge ${getBadge(reporte.status.toLowerCase())}'>${reporte.status}</span>
                            </li>
                            <li class='list-group-item'>
                                <div class='d-grid gap-2' data-status="${reporte.status.toLowerCase()}" data-bId="${reporte.building.id}" data-bName="${reporte.building.name}" data-title="${reporte.title}" data-description="${reporte.description}">
                                    <button onclick="abrirModal(this)"  type='button' class='btn btn-primary'>
                                        <i class='fas fa-edit me-2'></i> Editar
                                    </button>
                                    <!-- <button type='button' class='btn btn-danger'>
                                         <i class='fas fa-trash-alt me-2'></i> Eliminar
                                    </button> -->
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            `;

                // Agregar el HTML del reporte al contenedor
                reportesContainer.innerHTML += reporteHtml;
            });
        }

        function abrirModal(e) {
            const {
                bid,
                bname,
                description,
                title,
                status
            } = e.parentElement.dataset;

            edificio.innerHTML = `<option value="${bid}" selected>${bname}</option>`;

            edificio.value = bid;
            titulo.value = title;
            descripcion.value = description;
            estado.value = status;


            // Accion para guardar cambios
            guardarBtn.onclick = async () => {
                const formdata = new FormData();
                formdata.append('title', title);
                formdata.append('description', description);
                formdata.append('id_building', bid);
                formdata.append('status', estado.value);

                const request = await fetch(`${window.location.origin}/api/reports/${bid}`, {
                    method: 'POST',
                    body: formdata
                });

                if (request.status != 200) {
                    console.log(await request.json())
                    Swal.fire({
                        title: "¡Hubo un problema! :(",
                        text: "No pudo ser posible editar el reporte. Intentelo de nuevo o recargue la pagina",
                        icon: "error"
                    });
                    return;
                }

                Swal.fire({
                    title: "¡Reporte editado con exito!",
                    text: "El reporte ha sido modificado :)",
                    icon: "success"
                });

                $('#editarModal').modal('hide');

                mostrarReportes();
            }

            $('#editarModal').modal('show');
        }

        mostrarReportes();
    </script>



@endsection
