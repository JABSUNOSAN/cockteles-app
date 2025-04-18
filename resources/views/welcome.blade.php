<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
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
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row">
                <li class="nav-item me-2">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="bg-image">
        <div class="content">
            <!--  -->
            <div class="container text-center pt-2">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h2 class="text-white">Cócteles Populares</h2>

                <!-- Carousel de Cócteles Populares -->
                <div id="cocktailCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach($cocktails as $index => $cocktail)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div
                                    class="d-flex flex-column flex-md-row align-items-center justify-content-center custom-carousel-item">

                                    <!-- Imagen circular -->
                                    <div class="image-container mb-3 mb-md-0 me-md-4">
                                        <img src="{{ $cocktail['strDrinkThumb'] }}" alt="{{ $cocktail['strDrink'] }}"
                                            class="cocktail-img-circle">
                                    </div>

                                    <!-- Texto y botón -->
                                    <div class="text-container text-white text-center text-md-start">
                                        <h3>{{ $cocktail['strDrink'] }}</h3>
                                        <p class="d-none d-md-block">Un delicioso cóctel para disfrutar en cualquier
                                            ocasión.</p>
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

                    <!-- Controles -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#cocktailCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#cocktailCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

</html>