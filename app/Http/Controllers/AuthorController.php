<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    public function listAuthors()
    {
        $authors = Auth::user()->authors()->latest()->paginate(12);
        return view('Authors.index', ['authors' => $authors]);
    }

    public function formAuthor()
    {
        $authors = Auth::user()->authors;
        return view('Authors.form', ['authors' => $authors]);
    }

    public function saveAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:200',
            'age' => 'required|integer|min:5',
            'literary_genre' => ['required', Rule::in(Author::GENRES)],
            'nationality' => 'required|max:45',
        ], [
            'name.required' => 'O nome do autor é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O nome não pode passar de :max caracteres.',
            'age.required' => 'A idade do autor é obrigatória.',
            'age.integer' => 'A idade do autor deve ser um número inteiro.',
            'age.min' => 'A idade do autor deve ser pelo menos :min.',
            'literary_genre.required' => 'O gênero literário do autor é obrigatório.',
            'literary_genre.in' => 'Selecione um gênero literário válido da lista.',
            'nationality.required' => 'A nacionalidade do autor é obrigatória.',
            'nationality.max' => 'A nacionalidade não pode ultrapassar :max caracteres.',
        ]);

        $author = new Author();
        $author->user_id = Auth::id();
        $author->name = $request->name;
        $author->age = $request->age;
        $author->literary_genre = $request->literary_genre;
        $author->nationality = $request->nationality;

        $author->save();

        return redirect()->route('home')->with('success', 'Autor cadastrado com sucesso!');
    }
    public function editAuthor($id)
    {
       
        $decrypted_id = Operations::decryptId($id);


        $author = Auth::user()->authors()->findOrFail($decrypted_id);
        $authors = Auth::user()->authors;

        return view('authors.form', compact('author', 'authors'));
    }
    public function updateAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:200',
            'age' => 'required|integer|min:5',
            'literary_genre' => ['required', Rule::in(Author::GENRES)],
            'nationality' => 'required|max:45',
        ], [
            'name.required' => 'O nome do autor é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O nome não pode passar de :max caracteres.',
            'age.required' => 'A idade do autor é obrigatória.',
            'age.integer' => 'A idade do autor deve ser um número inteiro.',
            'age.min' => 'A idade do autor deve ser pelo menos :min.',
            'literary_genre.required' => 'O gênero literário do autor é obrigatório.',
            'literary_genre.in' => 'Selecione um gênero literário válido da lista.',
            'nationality.required' => 'A nacionalidade do autor é obrigatória.',
            'nationality.max' => 'A nacionalidade não pode ultrapassar :max caracteres.',
        ]);

        $id = Operations::decryptId($request->author_id);

        $Author = Auth::user()->Authors()->find($id);

        if (!$Author) {
            return redirect()->route('home')->with('error', 'Autor não encontrado.');
        }

        $Author->update([
            'name' => $request->name,
            'age' => $request->age,
            'literary_genre' => $request->literary_genre,
            'nationality' => $request->nationality,
        ]);

        return redirect()->route('home')->with('success', 'Autor atualizado com sucesso!');
    }

    public function showAuthor($id)
    {

        $author = Auth::user()->authors()->findOrFail($id);

        return view('authors.show', compact('author'));
    }

    public function deletarAutor($id)
    {
        $decrypted_id = Operations::decryptId($id);

        $Author = Auth::user()->Authors()->findOrFail($decrypted_id);
        if (!$Author) {
            return redirect()->route('home');
        }
         $Author->forceDelete();
        return redirect()->route('home');
    }


}