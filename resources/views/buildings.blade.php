@extends('panel/panel_layout')

@section('title', 'Edificios')
@section('content-size', 'xxl')

@section('aditional_header')
    <!-- <link rel="stylesheet" href="{{ asset('../../assets/vendor/libs/leaflet/leaflet.css') }}" /> -->
@endsection

@section('aditional_scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script src="{{ asset('../../assets/vendor/js/lit.js') }}"></script>
    <script type="module" src="{{ asset('../../assets/js/components/building-card/card-btn.js') }}"></script>
    <script type="module" src="{{ asset('../../assets/js/components/building-card/building-card.js') }}"></script>
    <script src="../../assets/js/ui-modals.js"></script>
    
    <script>
        function deleteBuild(e) {
            Swal.fire({
                title: `¿Confirma que desea eliminar el edificio ${e.parentElement.title}?`,
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

        function modifyBuild() {
            console.log("Modificar");
        }

        // Se pasa la funciones para borrar y modificar a los componentes
        let buildingsCards = document.querySelectorAll('building-card');
        console.log(buildingsCards);
        for (const card of buildingsCards) {
            card.modify_callback = modifyBuild;
            card.delete_callback = deleteBuild;
        }
    </script>
    <script>
        let searchInput = document.getElementById('search-input');
        searchInput.oninput = (e) => {
            alert(e.target.value)
            // Funcion de la barra de busqueda
        }
    </script>
@endsection

@section('aditional_css')
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
                                <label for="nameBasic" class="form-label">Identificador</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa el identificador">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBasic" class="form-label">Nombre</label>
                                <input type="text" id="nameBasic" class="form-control" placeholder="Ingresa el nombre">
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

        
        <building-card title="CMT-20" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="AD-46" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="KE-0806" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="CMT-03" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="CMT-03" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="CMT-03" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="CMT-03" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
        <building-card title="CMT-03" subtitle="Ciencias del Mar y de la Tierra I">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn" onclick="deleteBuild(this)"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn" data-bs-toggle="modal" data-bs-target="#basicModal"></uabcs-card-btn>
        </building-card>
    </div>
@endsection
