<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cocktail;
use GuzzleHttp\Client;

class CocktailController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail');
        $cocktails = json_decode($response->getBody()->getContents(), true)['drinks'];

        // Determinar qué vista mostrar basado en la autenticación
        if (auth()->check()) {
            return view('cocktails.index', compact('cocktails'));
        } else {
            // Limitar a los primeros 3 cócteles para la vista welcome
            $cocktails = array_slice($cocktails, 0, 3);
            return view('welcome', compact('cocktails'));
        }
    }

    public function getCocktailDetails($idDrink)
    {
        $client = new Client();
        try {
            $response = $client->get('https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $idDrink);
            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data['drinks'])) {
                return response()->json(['error' => 'Cóctel no encontrado'], 404);
            }

            return response()->json($data['drinks'][0]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener detalles del cóctel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tipo' => 'required|in:alcoholico,no alcoholico',
            //'instructions' => 'required|string',
            'image_url' => 'sometimes|url|nullable'
        ]);

        $existing = Cocktail::find($request->id);
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Este cóctel ya está guardado'
            ], 409);
        }
        try {
            $cocktail = Cocktail::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'tipo' => $request->tipo,
                    //'instructions' => $request->instructions,
                    'image_url' => $request->image_url,
                    'update_at' => now()
                ]
            );

            $message = $cocktail->wasRecentlyCreated ?
                'Cóctel guardado correctamente' :
                'Cóctel actualizado correctamente';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $cocktail
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cóctel: ' . $e->getMessage()
            ], 500);
        }
    }
    public function savedCocktails()
    {
        $cocktails = Cocktail::orderBy('update_at', 'desc')->get();
        return view('cocktails.saved', [
            'cocktails' => $cocktails,
            'currentUser' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        $cocktail = new Cocktail();
        $cocktail->name = $request->input('name');
        $cocktail->description = $request->input('description');
        $cocktail->save();
        return redirect()->route('cocktails.index');
    }

    public function showCocktails()
    {
        $cocktails = Cocktail::all();
        return view('cocktails.show', compact('cocktails'));
    }

    public function edit($id)
    {
        $cocktail = Cocktail::find($id);

        if (!$cocktail) {
            return response()->json(['error' => 'Cóctel no encontrado'], 404);
        }

        return view('cocktails.edit', compact('cocktail'));
    }

    public function update(Request $request, $id)
    {
        $cocktail = Cocktail::find($id);
        $cocktail->name = $request->input('name');
        $cocktail->description = $request->input('description');
        $cocktail->save();
        return redirect()->route('cocktails.show');
    }

    public function destroy($id)
    {
        $cocktail = Cocktail::find($id);

        if (!$cocktail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cóctel no encontrado'
            ], 404);
        }

        $cocktail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cóctel eliminado correctamente'
        ]);
    }
}
