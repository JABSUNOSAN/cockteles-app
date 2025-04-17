<?php>

@extends('layouts.app')

@section('title', 'Lista de Cócteles')

@section('content')
<div class="row">
    @foreach($cocktails['drinks'] as $cocktail)
        <div class="col-md-4">
            <div class="card">
            <img src="{{ $cocktail['strDrinkThumb'] }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5>{{ $cocktail['strDrink'] }}</h5>
                    <button class="btn btn-primary" onclick="saveCocktail({{ $cocktail['idDrink'] }})">Guardar</button>
                    <button class="btn btn-secondary" onclick="showCocktailDetails({{ $cocktail['idDrink'] }})">Ver detalles</button>
                    <div id="details-{{ $cocktail['idDrink'] }}"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

<script>
    function showCocktailDetails(idDrink) {
        $.ajax({
            type: 'GET',
            url: '/cocktails/' + idDrink + '/details',
            success: function(response) {
                $('#details-' + idDrink).html('<p>' + response.strInstructions + '</p>');
            }
        });
    }
</script>

