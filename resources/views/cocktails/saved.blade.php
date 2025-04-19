<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cócteles Guardados</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="gray-bg">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index') }}">
                <svg class="cocktail-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="3 3, 21 3, 12 12"></polygon>
                    <line x1="12" y1="12" x2="12" y2="20"></line>
                    <line x1="9" y1="21" x2="15" y2="21"></line>
                    <g class="garnish">
                        <line x1="6" y1="2" x2="14" y2="10"></line>
                        <circle cx="6" cy="2" r="1"></circle>
                    </g>
                </svg>
                Cócteles
            </a>
            
            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('index') }}">Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('cocktails.saved') }}">Mis Cócteles</a>
                    </li>
                </ul>
                
                <div class="dropdown">
                    <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="container pt-4">
            <h2 class="text-white text-center mb-4">Mis Cócteles Guardados</h2>
            
            <div class="row">
                @foreach($cocktails as $cocktail)
                <div class="col-md-4 mb-4">
                    <div class="card bg-transparent border-0">
                        <div class="d-flex justify-content-center">
                            <div class="image-container">
                                @if(isset($cocktail->image_url) && $cocktail->image_url)
                                    <img src="{{ $cocktail->image_url }}" alt="{{ $cocktail->name }}" class="cocktail-img-circle">
                                @else
                                    <img src="{{ asset('images/default-cocktail.png') }}" alt="{{ $cocktail->name }}" class="cocktail-img-circle">
                                @endif
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">{{ $cocktail->name }}</h5>
                            <p class="text-capitalize">{{ $cocktail->tipo }}</p>
                            
                            <div class="d-flex justify-content-center">
                                <!-- Botones de acción... (mantener igual que antes) -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal para Ver Detalles -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Detalles del Cóctel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="view-name"></h4>
                    <p><strong>Tipo:</strong> <span id="view-type"></span></p>
                    <p><strong>Ingredientes:</strong></p>
                    <p id="view-ingredients"></p>
                    <p><strong>Instrucciones:</strong></p>
                    <p id="view-instructions"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Editar Cóctel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" id="edit-type" class="form-select" required>
                                <option value="alcoholico">Alcohólico</option>
                                <option value="no alcoholico">No alcohólico</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ingredientes</label>
                            <textarea name="description" id="edit-ingredients" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instrucciones</label>
                            <textarea name="instructions" id="edit-instructions" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn custom-btn">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Configuración de los modales
        const viewModal = new bootstrap.Modal('#viewModal');
        const editModal = new bootstrap.Modal('#editModal');
        
        // Manejar clic en botón Ver
        $('.view-btn').click(function() {
            const id = $(this).data('id');
            
            $.get(`/cocktails/${id}`, function(data) {
                $('#view-name').text(data.name);
                $('#view-type').text(data.tipo === 'alcoholico' ? 'Alcohólico' : 'No alcohólico');
                $('#view-ingredients').text(data.description);
                $('#view-instructions').text(data.instructions);
                viewModal.show();
            });
        });
        
        // Manejar clic en botón Editar
        $('.edit-btn').click(function() {
            const id = $(this).data('id');
            
            $.get(`/cocktails/${id}`, function(data) {
                $('#edit-form').attr('action', `/cocktails/${id}`);
                $('#edit-name').val(data.name);
                $('#edit-type').val(data.tipo);
                $('#edit-ingredients').val(data.description);
                $('#edit-instructions').val(data.instructions);
                editModal.show();
            });
        });
        
        // Manejar clic en botón Eliminar
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            
            Swal.fire({
                title: '¿Eliminar cóctel?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d6d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/cocktails/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire(
                                '¡Eliminado!',
                                'El cóctel ha sido eliminado.',
                                'success'
                            ).then(() => location.reload());
                        }
                    });
                }
            });
        });
        
        // Manejar envío del formulario de edición
        $('#edit-form').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function() {
                    editModal.hide();
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'El cóctel ha sido actualizado.',
                        icon: 'success',
                        confirmButtonColor: '#ff4d6d'
                    }).then(() => location.reload());
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al actualizar',
                        icon: 'error',
                        confirmButtonColor: '#ff4d6d'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>