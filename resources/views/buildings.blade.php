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
    <script src="../../assets/js/ui-modals.js"></script>



    <script>
        let modal = new bootstrap.Modal(document.getElementById('basicModal'));

        function deleteBuild(e) {
            console.log(e.currentTarget);
            Swal.fire({
                title: `¿Confirma que desea eliminar el edificio ${e.currentTarget.parentElement.title}?`,
                text: "¡No sera posible revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, quiero eliminarlo!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: "¡Eliminado!",
                        text: "El edificio fue eliminado.",
                        icon: "success"
                    });
                }
            });
        }

        function modifyBuild(e) {
            let parent = e.target;
            modal.show();
            let tituloModal = document.getElementById('exampleModalLabel1');
            tituloModal.innerHTML = "Editar edificio";
            console.log(parent);
        }
    </script>

    <script>
        async function fetchBuildings() {
            apiUrl = `${window.location.origin}/api/buildings`;
            const token = window.user_info?.api_token ?? "";


            console.log(token);

            try {
                const response = await fetch(apiUrl, {
                    method: 'GET', // O el método que corresponda
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json', // Asegúrate de establecer el tipo de contenido adecuado
                    }
                });

                if (!response.ok) {
                    throw new Error(`Error al obtener la lista de edificios. Código de estado: ${response.status}`);
                }

                const buildings = await response.json();
                const mapWrapper = document.querySelector('.map_wrapper');
                const templateBuildingCard = document.getElementById('template-building-card');

                // Limpiar las building cards existentes
                // mapWrapper.innerHTML = '';

                // Renderizar las nuevas building cards con los datos obtenidos
                buildings.forEach(building => {
                    const clonedBuildingCard = document.importNode(templateBuildingCard.content, true);

                    // Actualizar los datos en el clon
                    const buildingCard = clonedBuildingCard.querySelector('building-card');
                    buildingCard.title = building.name;
                    buildingCard.subtitle = building.code_name;
                    buildingCard.dataset.id = building.id;

                    mapWrapper.insertBefore(clonedBuildingCard, document.getElementById('basicModal'));
                });

                // Se pasa la  funciones para borrar y modificar a los componentes
                let buildingsCards = document.querySelectorAll('building-card');
                console.log(buildingsCards);
                for (const card of buildingsCards) {
                    let btnDelete = card.querySelector('[slot="delete-btn"]');
                    let btnModify = card.querySelector('[slot="modify-btn"]');
                    btnDelete.onclick = (e) => deleteBuild(e);
                    btnModify.onclick = (e) => modifyBuild(e);

                }

            } catch (error) {
                console.error('Error al obtener la lista de edificios:', error.message);
            }
        }

        // Llamar a fetchBuildings para cargar las building cards inicialmente
        fetchBuildings();
    </script>



    <script>
        searchInput = document.getElementById('search-input');
        searchInput.oninput = (e) => {
            alert(e.target.value)
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
                                <input type="text" id="nameBasic" class="form-control"
                                    placeholder="Ingresa el nombre clave">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nombre</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa el nombre">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Latitud</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa la latitud">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Altitud</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa la altitud">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Radio</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa el radio">
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
                                        <input name="file" type="file" accept=".jpg, .jpeg, .png"/>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Fin --}}
        <!-- <div class="leaflet-map" id="basicMap"></div> -->
        <template id="template-building-card">
            <building-card data-id="">
                <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn"></uabcs-card-btn>
                <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn"></uabcs-card-btn>
            </building-card>
        </template>
    </div>
@endsection
