<?php
namespace App\Http\Controllers;

use App\Models\Actor;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActorController extends Controller
{
    public function listActors()
    {
        $actors = Auth::user()->actors()->orderBy('name')->get();
        return view('actors.index', compact('actors'));
    }

    public function formActor()
    {
        return view('actors.form');
    }

    public function saveActor(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:150',
        ], [
            'name.required' => 'O nome do ator/atriz é obrigatório.',
            'name.min'      => 'O nome deve ter pelo menos :min caracteres.',
            'name.max'      => 'O nome deve ter no máximo :max caracteres.',
        ]);

        $actor = new Actor();
        $actor->user_id = Auth::id();
        $actor->name    = $request->name;
        $actor->save();

        return redirect()->route('listarAtores')->with('success', 'Ator/Atriz cadastrado(a) com sucesso!');
    }

    public function editActor($id)
    {
        $decryptedId = Operations::decryptId($id);
        $actor = Auth::user()->actors()->findOrFail($decryptedId);

        return view('actors.form', compact('actor'));
    }

    public function updateActor(Request $request)
    {
        $request->validate([
            'actor_id' => 'required',
            'name'     => 'required|min:2|max:150',
        ], [
            'name.required' => 'O nome é obrigatório.',
        ]);

        $decryptedId = Operations::decryptId($request->actor_id);
        $actor = Auth::user()->actors()->findOrFail($decryptedId);

        $actor->update([
            'name' => $request->name,
        ]);

        return redirect()->route('listarAtores')->with('success', 'Ator/Atriz atualizado(a) com sucesso!');
    }

    public function showActor($id)
    {

        $actor = Auth::user()->actors()->findOrFail($id);

        return view('actors.show', compact('actor'));
    }

    public function deletarActor($id)
    {
        $decryptedId = Operations::decryptId($id);
        $actor = Auth::user()->actors()->findOrFail($decryptedId);
        $actor->delete();

        return redirect()->route('listarAtores')->with('success', 'Ator/Atriz removido(a) com sucesso!');
    }
}