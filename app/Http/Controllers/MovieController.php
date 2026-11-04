<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    public function index()
    {
        $moviesCount = Auth::user()->movies()->count();
        $directorsCount = Auth::user()->directors()->count();
        $actorsCount = Auth::user()->actors()->count();

        return view('home_movies', compact('moviesCount', 'directorsCount', 'actorsCount'));
    }

    public function listMovies()
    {
        $movies = Auth::user()->movies()->with(['director', 'actors'])->latest()->get();
        return view('movies.index', compact('movies'));
    }

    public function formMovie()
    {
        $directors = Auth::user()->directors()->orderBy('name')->get();
        $actors    = Auth::user()->actors()->orderBy('name')->get();

        return view('movies.form', compact('directors', 'actors'));
    }

    public function saveMovie(Request $request)
    {
        $request->validate([
            'title'       => 'required|min:2|max:200',
            'director_id' => 'nullable|exists:directors,id',
            'genre'       => ['nullable', Rule::in(Movie::GENRES)],
            'description' => 'nullable|max:2000',
            'actors'      => 'nullable|array',
            'actors.*'    => 'exists:actors,id',
        ], [
            'title.required'   => 'O título do filme é obrigatório.',
            'director_id.exists' => 'O diretor selecionado é inválido.',
            'genre.in'         => 'Selecione um gênero válido da lista.',
        ]);

        $movie = new Movie();
        $movie->user_id     = Auth::id();
        $movie->title       = $request->title;
        $movie->director_id = $request->director_id;
        $movie->genre       = $request->genre;
        $movie->description = $request->description;
        $movie->save();

        // Sincroniza a lista de atores selecionados na tabela pivot
        if ($request->has('actors')) {
            $movie->actors()->sync($request->actors);
        }

        return redirect()->route('listarFilmes')->with('success', 'Filme cadastrado com sucesso!');
    }

    public function editMovie($id)
    {
        $decryptedId = Operations::decryptId($id);
        $movie = Auth::user()->movies()->with('actors')->findOrFail($decryptedId);

        $directors = Auth::user()->directors()->orderBy('name')->get();
        $actors    = Auth::user()->actors()->orderBy('name')->get();

        return view('movies.form', compact('movie', 'directors', 'actors'));
    }

    public function updateMovie(Request $request)
    {
        $request->validate([
            'movie_id'    => 'required',
            'title'       => 'required|min:2|max:200',
            'director_id' => 'nullable|exists:directors,id',
            'genre'       => ['nullable', Rule::in(Movie::GENRES)],
            'description' => 'nullable|max:2000',
            'actors'      => 'nullable|array',
            'actors.*'    => 'exists:actors,id',
        ]);

        $decryptedId = Operations::decryptId($request->movie_id);
        $movie = Auth::user()->movies()->findOrFail($decryptedId);

        $movie->update([
            'title'       => $request->title,
            'director_id' => $request->director_id,
            'genre'       => $request->genre,
            'description' => $request->description,
        ]);

        // Atualiza a tabela pivot de atores
        $movie->actors()->sync($request->input('actors', []));

        return redirect()->route('listarFilmes')->with('success', 'Filme atualizado com sucesso!');
    }

    public function showMovie($id)
    {
        $decryptedId = Operations::decryptId($id);
        $movie = Auth::user()->movies()->with(['director', 'actors'])->findOrFail($decryptedId);

        return view('movies.show', compact('movie'));
    }

    public function deletarMovie($id)
    {
        $decryptedId = Operations::decryptId($id);
        $movie = Auth::user()->movies()->findOrFail($decryptedId);
        $movie->delete();

        return redirect()->route('listarFilmes')->with('success', 'Filme movido para a lixeira!');
    }

    public function listDeletedMovies()
    {
        $listaExcluidos = Auth::user()->movies()->onlyTrashed()->with('director')->get();
        return view('movies.deleted', compact('listaExcluidos'));
    }

    public function restoreMovie($id)
    {
        $decryptedId = Operations::decryptId($id);
        $movie = Auth::user()->movies()->onlyTrashed()->findOrFail($decryptedId);
        $movie->restore();

        return redirect()->route('listDeletedMovies')->with('success', 'Filme restaurado com sucesso!');
    }

    public function hardDeleteMovie($id)
    {
        $decryptedId = Operations::decryptId($id);
        $movie = Auth::user()->movies()->onlyTrashed()->findOrFail($decryptedId);
        
        // Remove os vínculos na tabela pivot e depois exclui permanentemente
        $movie->actors()->detach();
        $movie->forceDelete();

        return redirect()->route('listDeletedMovies')->with('success', 'Filme excluído permanentemente!');
    }
}