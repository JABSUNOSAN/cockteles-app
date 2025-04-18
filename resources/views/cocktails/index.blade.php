<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="gray-bg">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <svg class="cocktail-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Copa martini -->
                    <polygon points="3 3, 21 3, 12 12" />
                    <line x1="12" y1="12" x2="12" y2="20" />
                    <line x1="9" y1="21" x2="15" y2="21" />
                    <!-- Grupo: palillo + aceituna -->
                    <g class="garnish">
                        <line x1="6" y1="2" x2="14" y2="10" />
                        <circle cx="6" cy="2" r="1" />
                    </g>
                </svg>
                Cócteles
            </a>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                
                <!-- Hamburger para móvil -->
                <button class="navbar-toggler ms-2 d-block d-lg-none" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" 
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>

    <div class="">
        <div class="content">
            <div class="container pt-4">
                <h2 class="text-white text-center mb-4">Todos los Cócteles</h2>
                
                <div class="row">
                    @foreach($cocktails as $cocktail)
                    <div class="col-md-4 mb-4">
                        <div class="card bg-transparent border-0">
                            <div class="d-flex justify-content-center">
                                <div class="image-container">
                                    <img src="{{ $cocktail['strDrinkThumb'] }}" alt="{{ $cocktail['strDrink'] }}" 
                                         class="cocktail-img-circle">
                                </div>
                            </div>
                            <div class="card-body text-center text-white">
                                <h5 class="card-title">{{ $cocktail['strDrink'] }}</h5>
                                <a href="#" class="btn custom-btn mt-2 ver-detalle-btn"
                                    data-id="{{ $cocktail['idDrink'] }}" data-bs-toggle="modal"
                                    data-bs-target="#cocktailModal">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cocktailModal" tabindex="-1" aria-labelledby="cocktailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="cocktailModalLabel">Detalle del Cóctel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <h4 id="cocktail-name" class="mb-3"></h4>
                    <p><strong>Instrucciones:</strong></p>
                    <p id="cocktail-instructions"></p>
                    <p class="mt-4"><strong>Ingredientes:</strong></p>
                    <ul id="cocktail-ingredients" class="list-unstyled ps-3"></ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.ver-detalle-btn', function () {
            var idDrink = $(this).data('id');

            $.ajax({
                url: '/cocktails/' + idDrink,
                method: 'GET',
                success: function (data) {
                    $('#cocktail-name').text(data.strDrink);
                    $('#cocktail-instructions').text(data.strInstructions);

                    let ingredientes = '';
                    for (let i = 1; i <= 15; i++) {
                        let ingrediente = data['strIngredient' + i];
                        let medida = data['strMeasure' + i];
                        if (ingrediente) {
                            ingredientes += `<li>${medida ? medida : ''} ${ingrediente}</li>`;
                        }
                    }
                    $('#cocktail-ingredients').html(ingredientes);
                },
                error: function () {
                    $('#cocktail-name').text('Error al cargar los datos');
                    $('#cocktail-instructions').text('');
                    $('#cocktail-ingredients').html('');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>