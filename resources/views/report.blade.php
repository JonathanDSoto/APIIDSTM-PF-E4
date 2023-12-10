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
                                <option value='En Revisión'>En Revisión
                                </option>
                                <option value='Completado'>Completado</option>
                                <option value='Descartado'>Descartado</option>
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


@endsection

@section('aditional_scripts')
    <script>
        // Obtener el contenedor de reportes
        const reportesContainer = document.getElementById('reportes-container');

        async function mostrarReportes() {
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
                            <li class='list-group-item'><strong>Reporte:</strong> ${reporte.description}</li>
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
                                <strong>Departamento:</strong> $departamento
                            </li>
                            <li class='list-group-item'>
                                <strong>Estado:</strong>
                                <span class='badge ${getBadge(reporte.status.toLowerCase())}'>${reporte.status}</span>
                            </li>
                            <li class='list-group-item'>
                                <div class='d-grid gap-2'>
                                    <button  type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editarModal'>
                                        <i class='fas fa-edit me-2'></i> Editar
                                    </button>
                                    <button type='button' class='btn btn-danger'>
                                        <i class='fas fa-trash-alt me-2'></i> Eliminar
                                    </button>
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

        mostrarReportes();
    </script>



@endsection
