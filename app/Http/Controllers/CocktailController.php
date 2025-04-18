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
        $response = $client->get('https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $idDrink);
        $details = json_decode($response->getBody()->getContents(), true);
        return response()->json($details['drinks'][0]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tipo' => 'required|in:alcoholico,no alcoholico',
            //'instructions' => 'required|string'
        ]);

        try {
            $existing = Cocktail::find($request->id);
            if ($existing) {
                return response()->json([
                    'message' => 'Este cóctel ya está guardado en tu base de datos'
                ], 409);
            }

            $cocktail = Cocktail::create([
                'id' => $request->id,
                'name' => $request->name,
                'description' => $request->description,
                'tipo' => $request->tipo,
                //'instructions' => $request->instructions
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cóctel guardado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el cóctel: ' . $e->getMessage()
            ], 500);
        }
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
        $cocktail->delete();
        return redirect()->route('cocktails.show');
    }
}
