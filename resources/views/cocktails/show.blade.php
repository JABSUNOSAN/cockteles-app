<?php>

<div class="row">
    @foreach($cocktails as $cocktail)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $cocktail->name }}</h5>
                    <p>{{ $cocktail->description }}</p>
                    <a href="{{ route('cocktails.edit', $cocktail->id) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('cocktails.destroy', $cocktail->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
