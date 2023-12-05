@extends('panel/panel_layout')

@section('title', 'Departamentos')
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
<div class="map_wrapper">
    <button type="button" onclick="openAddModal()" class="btn btn-primary" style="width: calc((100% / 3) - 10px);">
        Agregar
    </button>

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
                    <button type="button" class="btn btn-primary" onclick="addDepartamento()">Agregar Departamento</button>                </div>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">Guardar Cambios</button>
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

    {{-- Template de Departamento --}}
    <template id="template-building-card">
        <building-card data-id="" imageUrl="" data-name="" data-codeName="">
            <uabcs-card-btn bgColor="red" icon="trash" slot="delete-btn"></uabcs-card-btn>
            <uabcs-card-btn bgColor="#7367f0" icon="pen" slot="modify-btn"></uabcs-card-btn>
        </building-card>
    </template>
</div>

<script>
    // Variable para simular la lista de departamentos
    const departamentos = [];

    // Función para abrir el modal de agregar
    function openAddModal() {
            $('#addModal').modal('show');
        }

        // Función para agregar un departamento
        function addDepartamento() {
            // Obtén los valores del formulario
            const nombreClave = $('#nombre_clave').val();
            const nombre = $('#nombre').val();
            const foto = '../../assets/img/elements/13.jpg'; // Puedes obtener la URL de la foto desde la biblioteca de carga

            // Crea un nuevo objeto de departamento
            const nuevoDepartamento = {
                nombreClave: nombreClave,
                nombre: nombre,
                foto: foto
            };

            // Agrega el nuevo departamento a la lista
            departamentos.push(nuevoDepartamento);

            // Clona el template y completa los valores
            const template = $('#template-building-card').clone();
            template.removeAttr('id'); // Para evitar duplicados de ID
            template.find('[data-name]').attr('data-name', nombre);
            template.find('[data-codeName]').attr('data-codeName', nombreClave);
            template.find('[imageUrl]').attr('imageUrl', foto);

            // Aplica estilos al nuevo departamento (esto es solo un ejemplo, personaliza según tus necesidades)
        template.find('building-card').css({
            'width': '200px', // Personaliza el ancho
            'height': 'auto', // Permite que la altura se ajuste automáticamente
            'margin': '10px', // Personaliza los márgenes
            'border': '1px solid #ccc', // Personaliza el borde
            'border-radius': '5px', // Personaliza la esquina redondeada
        });

            // Agrega el departamento al documento directamente
            $('body').append(template.html());

            // Cierra el modal de agregar
            $('#addModal').modal('hide');
        }

    function openEditModal() {
        $('#editModal').modal('show');
        // Puedes agregar lógica para cargar los datos del departamento a editar
    }

    function openDeleteModal() {
        $('#deleteModal').modal('show');
        // Puedes agregar lógica para cargar los datos del departamento a eliminar
    }

    function saveChanges() {
        // Lógica para guardar cambios en la edición del departamento (puedes usar Ajax)
        $('#editModal').modal('hide');
    }

    function deleteDepartamento() {
        // Lógica para eliminar un departamento (puedes usar Ajax)
        $('#deleteModal').modal('hide');
    }

    $(document).ready(function () {
        // Agrega aquí tu lógica de JavaScript para manejar la adición, edición y eliminación de departamentos
        // Puedes usar Ajax para enviar/recibir datos del servidor
        // Ejemplo: $('#btnAddDepartamento').on('click', function () { /* ... */ });
    });
</script>

@endsection