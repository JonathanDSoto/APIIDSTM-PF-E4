@extends('panel/panel_layout')

@section('title', 'Edificios')
@section('content-size', 'xxl')

@section('aditional_header')
<!-- <link rel="stylesheet" href="{{ asset('../../assets/vendor/libs/leaflet/leaflet.css') }}" /> -->
@endsection

@section('aditional_scripts')
<script src="../../assets/vendor/libs/dropzone/dropzone.js"></script>
<script src="../../assets/js/forms-file-upload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="{{ asset('../../assets/vendor/js/lit.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/card-btn.js') }}"></script>
<script type="module" src="{{ asset('../../assets/js/components/building-card/building-card.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{--
<script src="../../assets/js/ui-modals.js"></script> --}}

<script>
    let modal = new bootstrap.Modal(document.getElementById('basicModal'));
    async function deleteBuild(e) {
        const buildingCard = e.currentTarget.closest('building-card');
        const buildingId = buildingCard.data.id;

        try {
            // Realizar una solicitud POST a la API para simular la eliminación del edificio
            const apiUrl = `${window.location.origin}/api/buildings/${buildingId}`;
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

    function modifyBuild(e) {
        let buildingCard = e.target.closest('building-card');
        let tituloModal = document.getElementById('exampleModalLabel1');
        tituloModal.innerHTML = "Editar edificio";
        let btnTexto = document.getElementById('btnSaveChanges');
        btnTexto.innerHTML = "Guardar Cambios";

        // Obtener los datos del edificio desde el building-card
        const buildingId = buildingCard.data.id;

        // Obtener y llenar los datos en el formulario
        const nombreClaveInput = document.getElementById('nombre_clave');
        const nombreInput = document.getElementById('nombre');
        const latitudInput = document.getElementById('latitud');
        const altitudInput = document.getElementById('altitud');
        const radioInput = document.getElementById('radio');
        const imageInput = document.getElementById('dropzone-basic');

        const codeName = buildingCard.data.codeName;
        const name = buildingCard.data.name;
        const latitude = buildingCard.data.latitude;
        const longitude = buildingCard.data.longitude;
        const radius = buildingCard.data.radius;

        // Llenar los campos con los datos del edificio
        nombreClaveInput.value = codeName;
        nombreInput.value = name;
        latitudInput.value = latitude;
        altitudInput.value = longitude;
        radioInput.value = radius;
        // Mostrar el modal
        modal.show();

        // Agregar evento clic al botón "Guardar Cambios"
        const btnSaveChanges = document.getElementById('btnSaveChanges');
        btnSaveChanges.onclick = async () => {
            try {
                // Realizar una solicitud PUT a la API para actualizar el edificio
                const apiUrl = `${window.location.origin}/api/buildings/${buildingId}`;
                const token = window.user_info?.api_token ?? "";
                const form = new FormData();
                form.append('code_name', nombreClaveInput.value);
                form.append('name', nombreInput.value);
                form.append('latitude', latitudInput.value);
                form.append('altitude', altitudInput.value);
                form.append('radius', radioInput.value);

                if (imageInput.dropzone.files.length > 0) {
                    // Obtener el archivo del input
                    const file = imageInput.dropzone.files[0];

                    // Agregar el archivo al FormData
                    form.append('image_name', file, file.name);
                }
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(`Error al actualizar el edificio. Código de estado: ${response.status}`);
                }

                // Cerrar el modal
                modal.hide();

                // Mostrar mensaje de éxito
                Swal.fire({
                    title: "¡Actualizado!",
                    text: "El edificio fue actualizado exitosamente.",
                    icon: "success"
                });

                // Recargar las building cards
                fetchBuildings();

            } catch (error) {
                console.error('Error al actualizar el edificio:', error.message);

                // Mostrar un mensaje de error
                Swal.fire({
                    title: "Error",
                    text: "No se pudo actualizar el edificio.",
                    icon: "error"
                });
            }
        };
    }


    function addNewEdificio() {
        // Configurar el modal para agregar un nuevo usuario
        let tituloModal = document.getElementById('exampleModalLabel1');
        tituloModal.innerHTML = "Agregar Nuevo Edificio";
        let btnTexto = document.getElementById('btnSaveChanges');
        btnTexto.innerHTML = "Agregar";
        // Restablecer los valores del formulario
        const nombreClaveInput = document.getElementById('nombre_clave');
        const nombreInput = document.getElementById('nombre');
        const latitudInput = document.getElementById('latitud');
        const altitudInput = document.getElementById('altitud');
        const radioInput = document.getElementById('radio');
        const imageInput = document.getElementById('dropzone-basic');

        nombreClaveInput.value = '';
        nombreInput.value = '';
        latitudInput.value = '';
        altitudInput.value = '';
        radioInput.value = '';
        imageInput.dropzone.removeAllFiles();

        // Mostrar el modal
        modal.show();

        // Agregar evento clic al botón "Guardar Cambios"
        const btnSaveChanges = document.getElementById('btnSaveChanges');
        btnSaveChanges.onclick = async () => {
            try {
                // Construir el objeto FormData con los datos del nuevo usuario
                const form = new FormData();
                form.append('code_name', nombreClaveInput.value);
                form.append('name', nombreInput.value);
                form.append('latitude', latitudInput.value);
                form.append('altitude', altitudInput.value);
                form.append('radius', radioInput.value);

                if (imageInput.dropzone.files.length > 0) {
                    const file = imageInput.dropzone.files[0];
                    form.append('image_name', file, file.name);
                }

                // Realizar una solicitud POST a la API para agregar un nuevo usuario
                const apiUrl = `${window.location.origin}/api/buildings`;
                const token = window.user_info?.api_token ?? "";
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                    body: form,
                });

                if (!response.ok) {
                    throw new Error(`Error al agregar el edificio. Código de estado: ${response.status}`);
                }

                // Cerrar el modal
                modal.hide();

                // Mostrar mensaje de éxito
                Swal.fire({
                    title: "¡Usuario Agregado!",
                    text: "El nuevo edificio fue agregado exitosamente.",
                    icon: "success"
                });

                // Recargar la lista de usuarios
                fetchBuildings();

            } catch (error) {
                console.error('Error al agregar el usuario:', error.message);

                // Mostrar un mensaje de error
                Swal.fire({
                    title: "Error",
                    text: "No se pudo agregar el usuario.",
                    icon: "error"
                });
            }
        };
    }

    async function fetchBuildings() {
        const apiUrl = `${window.location.origin}/api/buildings`;
        const token = window.user_info?.api_token ?? "";
        console.log(token);
        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error(`Error al obtener la lista de edificios. Código de estado: ${response.status}`);
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
                    latitude: building.latitude,
                    longitude: building.altitude,
                    radius: building.radius,
                    imageUrl: building.image_url
                };


                // Icono de editar
                const btnEdit = document.createElement('uabcs-card-btn');
                btnEdit.setAttribute('slot', 'modify-btn');
                btnEdit.setAttribute('icon', 'pen');
                btnEdit.setAttribute('bgColor', '#7367f0');
                btnEdit.onclick = (e) => modifyBuild(e);

                // Icono de eliminar
                const btnDelete = document.createElement('uabcs-card-btn');
                btnDelete.setAttribute('icon', 'trash');
                btnDelete.setAttribute('slot', 'delete-btn');
                btnDelete.setAttribute('bgColor', 'red');
                btnDelete.onclick = (e) => deleteBuild(e);

                // Agregar botones a la nueva tarjeta
                newCard.appendChild(btnEdit);
                newCard.appendChild(btnDelete);
                // Agregar nueva tarjeta al contenedor
                mapWrapper.appendChild(newCard);
            });
        } catch (error) {
            console.error('Error al oa lista de edificios:', error.message);
        }
    }

    // Llamar a fetchBuildings para cargar las building cards inicialmente
    fetchBuildings();

</script>

<script>
    searchInput = document.getElementById('search-input');
    searchInput.oninput = (e) => {
        target.value()
        // Funcion de la barra de busqueda
    }
</script>
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


@section('content')
<div class="map_wrapper" style="">
    <button type="button" onclick="addNewEdificio()" class="btn btn-primary"
        style="width: calc((100% / 3) - 10px);">Agregar</button>
    {{-- Modal inicio --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Editar Edificio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nombre Clave</label>
                            <input type="text" id="nombre_clave" class="form-control"
                                placeholder="Ingresa el nombre clave">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nombre</label>
                            <input type="text" id="nombre" class="form-control" placeholder="Ingresa el nombre">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Latitud</label>
                            <input type="text" id="latitud" class="form-control" placeholder="Ingresa la latitud">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Altitud</label>
                            <input type="text" id="altitud" class="form-control" placeholder="Ingresa la altitud">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Radio</label>
                            <input type="text" id="radio" class="form-control" placeholder="Ingresa el radio">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Foto del edificio</label>

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
                    <button type="button" class="btn btn-primary" id="btnSaveChanges">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Fin --}}
    <!-- <div class="leaflet-map" id="basicMap"></div> -->

</div>
@endsection