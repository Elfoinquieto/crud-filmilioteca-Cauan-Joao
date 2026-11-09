<?php
namespace App\Http\Controllers;

use App\Models\Director;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectorController extends Controller
{
    public function listDirectors()
    {
        $directors = Auth::user()->directors()->orderBy('name')->latest()->paginate(12);
        return view('directors.index', compact('directors'));
    }

    public function formDirector()
    {
        return view('directors.form');
    }

    public function saveDirector(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:150',
        ], [
            'name.required' => 'O nome do diretor é obrigatório.',
            'name.min'      => 'O nome deve ter pelo menos :min caracteres.',
            'name.max'      => 'O nome deve ter no máximo :max caracteres.',
        ]);

        $director = new Director();
        $director->user_id = Auth::id();
        $director->name    = $request->name;
        $director->save();

        return redirect()->route('listarDiretores')->with('success', 'Diretor cadastrado com sucesso!');
    }

    public function editDirector($id)
    {
        $decryptedId = Operations::decryptId($id);
        $director = Auth::user()->directors()->findOrFail($decryptedId);

        return view('directors.form', compact('director'));
    }

    public function updateDirector(Request $request)
    {
        $request->validate([
            'director_id' => 'required',
            'name'        => 'required|min:2|max:150',
        ], [
            'name.required' => 'O nome do diretor é obrigatório.',
        ]);

        $decryptedId = Operations::decryptId($request->director_id);
        $director = Auth::user()->directors()->findOrFail($decryptedId);

        $director->update([
            'name' => $request->name,
        ]);

        return redirect()->route('listarDiretores')->with('success', 'Diretor atualizado com sucesso!');
    }

    public function showDirector($id)
    {
        $decryptedId = Operations::decryptId($id);
        $director = Auth::user()->directors()->findOrFail($decryptedId);

        return view('directors.show', compact('director'));
    }

    public function deletarDirector($id)
    {
        $decryptedId = Operations::decryptId($id);
        $director = Auth::user()->directors()->findOrFail($decryptedId);
        $director->delete();

        return redirect()->route('listarDiretores')->with('success', 'Diretor removido com sucesso!');
    }
}