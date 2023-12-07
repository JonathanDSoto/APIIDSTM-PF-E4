@extends('panel/panel_layout')

@section('title', 'Departamentos')
@section('content-size', 'xxl')

@section('aditional_header')
<!-- <link rel="stylesheet" href="{{ asset('../../assets/vendor/libs/leaflet/leaflet.css') }}" /> -->
@endsection

@section('aditional_css')
<link rel="stylesheet" href="../../assets/vendor/libs/dropzone/dropzone.css" />

<style>
    .map_wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
</style>
@endsection

@section('aditional_scripts')
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="{{ asset('../../assets/vendor/js/lit.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/card-btn.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/building-card.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Variable para simular la lista de departamentos
    const departamentos = [];

    // Función para abrir el modal de agregar
    function openAddModal() {
        $('#addModal').modal('show');
        addNewEdificio();
    }

    // Función para agregar un departamento
    // Función para agregar un departamento
    function addNewEdificio() {
        // Restablecer los valores del formulario
        const nombreClaveInput = document.getElementById('nombre_clave');
        const nombreInput = document.getElementById('nombre');
        const imageInput = document.getElementById('dropzone-basic');
        nombreClaveInput.value = '';
        nombreInput.value = '';
        imageInput.dropzone.removeAllFiles();

        // Agregar evento clic al botón "Guardar Cambios"
        const btnAddDept = document.getElementById('btnAddDept');
        btnAddDept.onclick = async () => {
            try {
                // Construir el objeto FormData con los datos del nuevo usuario
                const form = new FormData();
                form.append('name', nombreInput.value);
                form.append('code_name', nombreClaveInput.value);

                if (imageInput.dropzone.files.length > 0) {
                    const file = imageInput.dropzone.files[0];
                    form.append('image', file, file.name);
                }

                // Realizar una solicitud POST a la API para agregar un nuevo usuario
                const apiUrl = `${window.location.origin}/api/department`;
                const token = window.user_info?.api_token ?? "";
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(`Error al agregar el departamento. Código de estado: ${response.status}`);
                }

                // Cerrar el modal
                $('#addModal').modal('hide');

                // Mostrar mensaje de éxito
                Swal.fire({
                    title: "¡Usuario Agregado!",
                    text: "El nuevo departamento fue agregado exitosamente.",
                    icon: "success"
                });

                // Recargar la lista de usuarios
                fetchDepartment();

            } catch (error) {
                console.error('Error al agregar el Departamento:', error.message);

                // Mostrar un mensaje de error
                Swal.fire({
                    title: "Error",
                    text: "No se pudo agregar el Departamento.",
                    icon: "error"
                });
            }
        };
    }

    function openEditModal(e) {
        $('#editModal').modal('show');
        modifyDept(e);
        // Puedes agregar lógica para cargar los datos del departamento a editar
    }

    function openDeleteModal() {
        $('#deleteModal').modal('show');
        // Puedes agregar lógica para cargar los datos del departamento a eliminar
    }

    async function modifyDept(e) {
        let buildingCard = e.target.closest('building-card');
        const buildingId = buildingCard.data.id;

        const nombreClaveInput = document.getElementById('edit_nombre_clave');
        const nombreInput = document.getElementById('edit_nombre');
        const imageInputEdit = document.getElementById('dropzone-basic-edit');

        const codeName = buildingCard.data.codeName;
        const name = buildingCard.data.name;

        nombreClaveInput.value = codeName;
        nombreInput.value = name;

        const btnSaveChanges = document.getElementById('btnSaveChanges');
        btnSaveChanges.onclick = async () => {
            try {
                const apiUrl = `${window.location.origin}/api/department/${buildingId}`;
                const token = window.user_info?.api_token ?? "";
                const form = new FormData();
                form.append('code_name', nombreClaveInput.value);
                form.append('name', nombreInput.value);

                if (imageInput.dropzone.files.length > 0) {
                    const file = imageInputEdit.dropzone.files[0];
                    form.append('image', file, file.name);
                }

                const response = await fetch(apiUrl, {
                    method: 'POST',  // Sí, aún usamos POST, pero con _method=PUT en el cuerpo
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(`Error al actualizar el edificio. Código de estado: ${response.status}`);
                }

                $('#editModal').modal('hide');
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "El edificio fue actualizado exitosamente.",
                    icon: "success"
                });

                fetchDepartment();

            } catch (error) {
                console.error('Error al actualizar el edificio:', error.message);
                $('#editModal').modal('hide');
                Swal.fire({
                    title: "Error",
                    text: "No se pudo actualizar el edificio.",
                    icon: "error"
                });
            }
        };
    }

    function deleteDepartamento(e) {
        $('#deleteModal').modal('hide');
        deleteDept(e);

    }

    async function deleteDept(e) {
        const buildingCard = e.currentTarget.closest('building-card');
        const buildingId = buildingCard.data.id;
        console.log(buildingId);
        try {
            // Realizar una solicitud POST a la API para simular la eliminación del edificio
            const apiUrl = `${window.location.origin}/api/department/${buildingId}`;
            const token = window.user_info?.api_token ?? "";
            const response = await fetch(apiUrl, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                credentials: 'include',
            });

            if (response.ok) {
                // Eliminar la building card del front-end
                buildingCard.remove();

                // Mostrar un mensaje de éxito
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El edificio fue eliminado.",
                    icon: "success"
                });
            } else if (response.status === 404) {
                // El edificio no fue encontrado
                Swal.fire({
                    title: "Error",
                    text: "El edificio no se encontró.",
                    icon: "error"
                });
            } else {
                // Otro error en la solicitud DELETE
                throw new Error(`Error al eliminar el edificio. Código de estado: ${response.status}`);
            }
        } catch (error) {
            console.error('Error al eliminar el edificio:', error.message);

            // Mostrar un mensaje de error genérico
            Swal.fire({
                title: "Error",
                text: "No se pudo eliminar el edificio.",
                icon: "error"
            });
        }
    }

    $(document).ready(function () {
        // Agrega aquí tu lógica de JavaScript para manejar la adición, edición y eliminación de departamentos
        // Puedes usar Ajax para enviar/recibir datos del servidor
        // Ejemplo: $('#btnAddDepartamento').on('click', function () { /* ... */ });
    });

    async function fetchDepartment() {
        const apiUrl = `${window.location.origin}/api/department`;
        const token = window.user_info?.api_token ?? "";
        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error(`Error al obtener la lista de departamentos. Código de estado: ${response.status}`);
            }

            const buildings = await response.json();
            const mapWrapper = document.querySelector('.map_wrapper');

            // Limpiar las building cards existentes
            const existentes = document.querySelectorAll('building-card');
            existentes.forEach((e) => {
                e.remove();
            });

            // Renderizar las nuevas building cards con los datos obtenidos
            buildings.forEach(building => {
                const newCard = document.createElement('building-card');
                newCard.data = {
                    id: building.id,
                    name: building.name,
                    codeName: building.code_name,
                    imageUrl: building.image_url
                };


                // Icono de editar
                const btnEdit = document.createElement('uabcs-card-btn');
                btnEdit.setAttribute('slot', 'modify-btn');
                btnEdit.setAttribute('icon', 'pen');
                btnEdit.setAttribute('bgColor', '#7367f0');
                btnEdit.onclick = (e) => openEditModal(e);

                // Icono de eliminar
                const btnDelete = document.createElement('uabcs-card-btn');
                btnDelete.setAttribute('icon', 'trash');
                btnDelete.setAttribute('slot', 'delete-btn');
                btnDelete.setAttribute('bgColor', 'red');
                btnDelete.onclick = (e) => deleteDept(e);


                // Agregar botones a la nueva tarjeta
                newCard.appendChild(btnEdit);
                newCard.appendChild(btnDelete);
                // Agregar nueva tarjeta al contenedor
                mapWrapper.appendChild(newCard);
            });
        } catch (error) {
            console.error('Error al cargar la lista de departamentos:', error.message);
        }
    }
    // Llamar a fetchDepartment para cargar las building cards inicialmente
    fetchDepartment();
</script>
@endsection


@section('content')
<div class="map_wrapper">
    <button type="button" onclick="openAddModal()" onclick="openAddModal()" class="btn btn-primary"
        style="width: calc((100% / 3) - 10px);">
        Agregar
    </button>


    {{-- Template de Departamento --}}
    {{-- <template id="template-building-card">
        <building-card data-id="" imageUrl="" data-name="" data-codeName="">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn"></uabcs-card-btn>
        </building-card>
    </template> --}}
</div>

{{-- Modal de Agregar --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Agregar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nombre_clave" class="form-label">Nombre Clave</label>
                        <input type="text" id="nombre_clave" class="form-control" placeholder="Ingresa el nombre clave">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" class="form-control" placeholder="Ingresa el nombre">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Foto del Departamento</label>
                        <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                            id="dropzone-basic">
                            <div class="dz-message needsclick">
                                Arrastre la imagen aquí o haz clic para subirla
                                {{-- <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                    <span class="fw-medium">not</span> actually uploaded.)</span> --}}
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" accept=".jpg, .jpeg, .png" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAddDept">Agregar Departamento</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Edición --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Editar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario de edición -->
                <form id="editForm">
                    <div class="mb-3">
                        <label for="edit_nombre_clave" class="form-label">Nombre Clave</label>
                        <input type="text" id="edit_nombre_clave" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Foto del Departamento</label>
                        <form action="https://demos.pixinvent.com/upload" class="dropzone needsclick"
                            id="dropzone-basic-edit">
                            <div class="dz-message needsclick">
                                Arrastre la imagen aquí o haz clic para subirla
                                {{-- <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                    <span class="fw-medium">not</span> actually uploaded.)</span> --}}
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" accept=".jpg, .jpeg, .png" />
                            </div>
                        </form>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSaveChanges">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Eliminar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este departamento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="deleteDepartamento()">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection