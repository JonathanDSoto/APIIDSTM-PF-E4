@extends('panel/panel_layout')

@section('title', "Edificios")
@section('content-size', "fluid")

@section('aditional_header')
    <link rel="stylesheet" href="{{asset('../../assets/vendor/libs/leaflet/leaflet.css')}}" />
@endsection

@section('aditional_scripts')
  <script src="{{asset('../../assets/vendor/libs/leaflet/leaflet.js')}}"></script>
  <script>
    var map = L.map('basicMap', {
        
    center: [24.1014123, -110.314885],
    zoom: 17
});
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar', attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
  </script>
@endsection

@section('aditional_css')
    <style>
        .map_wrapper {
            background: red;
            width: calc(100% - 5.25rem);
            height: 100%;
            position: absolute;
            top: 0;
            left: 5.25rem;
        }
        .leaflet-map {
            height: 100%;
        }
    </style>
@endsection


@section('content')
    <div class="map_wrapper" style="">
        <div class="leaflet-map" id="basicMap"></div>
        
    </div>
@endsection