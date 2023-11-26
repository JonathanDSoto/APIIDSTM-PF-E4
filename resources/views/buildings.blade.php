@extends('panel/panel_layout')

@section('title', "Edificios")
@section('content-size', "xxl")

@section('aditional_header')
    <!-- <link rel="stylesheet" href="{{asset('../../assets/vendor/libs/leaflet/leaflet.css')}}" /> -->
@endsection

@section('aditional_scripts')
  <!-- <script src="{{asset('../../assets/vendor/libs/leaflet/leaflet.js')}}"></script>
  <script>
    var map = L.map('basicMap', {    
        center: [24.1014123, -110.314885],
        zoomControl: false,
        zoom: 17,
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar', attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
    L.control.zoom({
        position:'bottomright'
    }).addTo(map);
  </script> -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
  <script src="{{asset('../../assets/vendor/js/lit.js')}}"></script>
  <script type="module" src="{{asset('../../assets/js/components/building-card.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function deleteBuild(e) {
        Swal.fire({
            title: `¿Confirma que desea eliminar el edificio ${e.title}?`,
            text: "¡No sera posible revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sii, quiero eliminarlo!",
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
@endsection

@section('aditional_css')
    <style>
        /* .map_wrapper {
            background: red;
            width: calc(100% - 5.25rem);
            height: 100%; */
            /* position: absolute; */
            /* top: 0;
            left: 5.25rem;
        }
        .leaflet-map {
            height: 100%;
        } */
        /* swiper-container {
            position: absolute;
            bottom: 0;
            z-index: 1;
        } */
        .map_wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
    </style>
@endsection


@section('content')
    <div class="map_wrapper" style="">
        <!-- <div class="leaflet-map" id="basicMap"></div> -->
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="AD-46"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>
        <building-card
            title="CMT-03"
            subtitle="Ciencias del Mar y de la Tierra I"
        ></building-card>

        <!-- <swiper-container slides-per-view="auto">
            <swiper-slide>
            </swiper-slide>
            <swiper-slide>Slide 2</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>
            <swiper-slide>Slide 3</swiper-slide>

        </swiper-container> -->
    </div>
@endsection