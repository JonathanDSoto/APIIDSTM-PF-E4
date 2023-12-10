@extends('panel/panel_layout')

@section('title', 'Iniciativa')
@section('content-size', 'xxl')

@section('aditional_header')


@endsection

@section('aditional_css')
    <link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />

@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">UABCS/</span> Iniciativas
    </h4>

    <div class="row" id="iniciativas-container">
        <!-- Contenedor de iniciativas generado dinámicamente con JavaScript -->
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
                            <label for="departamentoIniciativa" class="form-label">Departamento</label>
                            <select class="form-control" name="departamentoIniciativa" id="departamentoIniciativa"
                                disabled></select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionIniciativa" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionIniciativa" rows="3" disabled></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fechaIniciativa" class="form-label">Fecha</label>
                            <input type="datetime-local" class="form-control" id="fechaIniciativa" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="estadoIniciativa" class="form-label">Estado</label>
                            <select class="form-select" id="estadoIniciativa">
                                <option value="en revisión">En revisión</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="descartado">Descartado</option>
                            </select>
                        </div>
                    </form>

                    {{-- <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Foto de Materia</label>
                            <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                                id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    Arrastre la imagen aquí o haz clic para subirla --}}
                    {{-- <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                      <span class="fw-medium">not</span> actually uploaded.)</span> --}}
                    {{-- </div>
                                <div class="fallback">
                                    <input name="file" type="file" accept=".jpg, .jpeg, .png" />
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button id="saveBtn" type="button" class="btn btn-primary" id="guardarCambiosBtn">
                        <i class="ti ti-check me"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('aditional_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="../../assets/js/forms-file-upload.js"></script>
    <script>
        const modal = $('#editModal');
        const iniciativasContainer = document.getElementById('iniciativas-container');
        const titulo = document.getElementById('tituloIniciativa');
        const descripcion = document.getElementById('descripcionIniciativa');
        const estado = document.getElementById('estadoIniciativa');
        const fecha = document.getElementById('fechaIniciativa');
        const departamentoIniciativa = document.getElementById('departamentoIniciativa');
        const saveBtn = document.getElementById('saveBtn');


        async function mostrarIniciativas() {
            iniciativasContainer.innerHTML = "";
            const badgeClass = {
                'aprobado': 'bg-success',
                'descartado': 'bg-danger',
                'en revisión': 'bg-warning',
            };
            const getBadge = (status) => badgeClass[status] ?? 'bg-secondary';

            const request = await fetch(`${window.location.origin}/api/initiative`);
            let iniciativas;

            if (request.status != 200) {
                Swal.fire({
                    title: "¡Oh no! Hubo un error con cargar la iniciativas",
                    text: "Intentelo mas tarde o comuniquese con un administrador.",
                    icon: "error"
                });
                return;
            }

            iniciativas = await request.json();
            if (!iniciativas) {
                Swal.fire({
                    title: "¡Oh no! No encontramos ninguna iniciativa :(",
                    text: "Espera a que algun estudiante registre una.",
                    icon: "error"
                });
            }

            // Iterar sobre las iniciativas
            iniciativas.forEach(function(iniciativa) {
                // console.log(iniciativa);
                let {
                    name,
                    image,
                    description,
                    department,
                    isApproved,
                    created_at,
                    user,
                    status
                } = iniciativa;

                // Generar código HTML para cada iniciativa
                var iniciativaHtml = `
                <div class='col-xl-4 col-md-6 mb-4'>
                    <div class='card ios-card position-relative'>
                        <div class='position-absolute top-0 end-0 m-4'>
                            <div class='d-flex btn-container'>
                                <!-- Aqui va el boton --> 
                            </div>
                        </div>
                        <h5 class='card-header ios-header'><strong>${name}</strong></h5>
                        <div class='card-body ios-body'>
                            <div class='text-center mb-2'>
                                <img src='${iniciativa.image}' alt='Imagen de iniciativa' class='img-fluid object-fit'>
                            </div>
                            <p class='card-text ios-text'><strong>Descripción: </strong>${description}</p>
                            <p class='card-text ios-text m-0'><strong>Fecha: </strong>${getFormatDate(created_at)}</p>
                            <p class='card-text ios-text m-0'><strong>Departamento: </strong>${department.name}</p>
                            <div class='d-flex align-items-center mb-2'>
                                <p class='card-text ios-text m-0'><strong>Usuario: </strong></p>
                                <div class='avatar-group ms-2 d-flex align-items-center'>
                                    <div data-bs-toggle='tooltip' data-popup='tooltip-custom' data-bs-placement='top' class='avatar avatar-xs pull-up' title='${iniciativa.usuario}'>
                                        <img src='https://ui-avatars.com/api/?name=${user.name}+${user.lastname}' alt='Avatar' class='rounded-circle' style="object-fit:cover;">
                                    </div>
                                    <span class='ms-1'>${user.name} ${user.lastname}</span>
                                </div>
                            </div>
                            <p class='card-text ios-text'>
                                <strong>Estado: </strong>
                                <span class='badge ${getBadge(status)}'>
                                    ${status[0].toUpperCase() + status.slice(1)}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            `;

                const range = document.createRange();
                const iniciativaCard = range.createContextualFragment(iniciativaHtml);


                const showModal = document.createElement('button');
                showModal.onclick = mostrarEditar;
                showModal.initiative = iniciativa;
                showModal.innerHTML = `
                <i class='ti ti-pencil'></i>
                Cambiar estado
                `;

                showModal.classList.add('btn', 'btn-outline-primary', 'btn-sm', 'edit-button', 'ms-2');
                iniciativaCard.querySelector('.btn-container').appendChild(showModal);

                // Agregar el HTML de la iniciativa al contenedor
                iniciativasContainer.appendChild(iniciativaCard);
            });

        }

        function mostrarEditar(e) {
            const {
                id,
                name,
                image,
                description,
                department,
                isApproved,
                created_at,
                user,
                status
            } = e.target.initiative;

            titulo.value = name;
            departamentoIniciativa.innerHTML = `<option value="${department.id}" selected>${department.name}</option>`
            descripcion.value = description;
            estado.value = status;
            fecha.value = getFormatDate(created_at, true);

            saveBtn.onclick = async () => {
                const formdata = new FormData();
                formdata.append('status', estado.value)

                const request = await fetch(`${window.location.origin}/api/initiative/${id}`, {
                    method: 'POST',
                    body: formdata
                });

                if (request.status != 200) {
                    Swal.fire({
                        title: "¡Oh no! Ocurrio un error :(",
                        text: "Intentelo de nuevo.",
                        icon: "error"
                    });
                    return;
                }

                Swal.fire({
                    title: "¡Excelente! La informacion fue actualizada correctamente",
                    text: "Los cambios fueron registrados con exito.",
                    icon: "success"
                });
                mostrarIniciativas();
            }

            // estado.value=

            modal.modal('show');
        }

        function getFormatDate(date, inputFormat = false) {
            const d = new Date(date);
            const año = d.getFullYear();
            const mes = String(d.getMonth() + 1).padStart(2, '0');
            const dia = String(d.getDate()).padStart(2, '0');
            const horas = String(d.getHours()).padStart(2, '0');
            const minutos = String(d.getMinutes()).padStart(2, '0');
            const segundos = String(d.getSeconds()).padStart(2, '0');

            return inputFormat ? `${año}-${mes}-${dia}T${horas}:${minutos}:${segundos}` :
                `${dia}/${mes}/${año} ${horas}:${minutos}:${segundos}`
        }

        mostrarIniciativas();
    </script>

@endsection
