<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class BookController extends Controller
{
    public function index()
    {
        $latestBooks = Auth::user()->books()->latest()->take(4)->get();
        $authorsCount = Auth::user()->authors()->count();

        return view('home_books', compact('latestBooks', 'authorsCount'));
    }

    public function listBooks()
    {
        $books = Auth::user()->books()->latest()->paginate(12);
        return view('books.index', ['books' => $books]);
    }

    public function formBook()
    {
        $authors = Auth::user()->authors;
        return view('books.form', ['authors' => $authors]);
    }

    public function saveBook(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:200',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|string|max:13',
            'genre' => ['required', Rule::in(Book::GENRES)],
            'description' => 'required|max:2000',
            'capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.required' => 'O título do livro é obrigatório.',
            'title.min' => 'O título deve ter pelo menos :min caracteres.',
            'title.max' => 'O título não pode passar de :max caracteres.',
            'author_id.required' => 'O autor do livro é obrigatório.',
            'author_id.exists' => 'O autor selecionado é inválido.',
            'isbn.required' => 'O código ISBN do livro é obrigatório.',
            'genre.required' => 'O gênero do livro é obrigatório.',
            'genre.in' => 'Selecione um gênero válido da lista.',
            'description.required' => 'A descrição do livro é obrigatório.',
            'description.max' => 'A descrição não pode ultrapassar :max caracteres.',
            'capa.image' => 'O arquivo enviado deve ser uma imagem.',
            'capa.mimes' => 'A imagem deve estar no formato: jpeg, png, jpg ou webp.',
            'capa.max' => 'A capa não pode ser maior que 2MB.',
        ]);

        $book = new Book();
        $book->user_id = Auth::id();
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->isbn = $request->isbn;
        $book->genre = $request->genre;
        $book->description = $request->description;

        if ($request->hasFile('capa')) {
            $capa = $request->file('capa');
            $caminhoOriginal = $capa->storePublicly('capas', 'public');

            $nomeWebp = pathinfo($capa->hashName(), PATHINFO_FILENAME) . '.webp';
            $caminhoThumbnail = 'capas/thumbs/' . $nomeWebp;

            $manager = ImageManager::gd();
            $imagemThumb = $manager->read($capa)->cover(300, 400)->toWebp();
            Storage::disk('public')->put($caminhoThumbnail, (string) $imagemThumb);

            $book->capa = $caminhoOriginal;
            $book->capa_thumbnail = $caminhoThumbnail;
        }

        $book->save();

        return redirect()->route('home')->with('success', 'Livro cadastrado com sucesso!');
    }

    public function editBook($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $book = Auth::user()->books()->findOrFail($decrypted_id);
        $authors = Auth::user()->authors;

        return view('books.form', ['book' => $book, 'authors' => $authors]);
    }

    public function updateBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'title' => 'required|min:2|max:200',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|string|max:13',
            'genre' => ['required', Rule::in(Book::GENRES)],
            'description' => 'required|max:2000',
            'capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.required' => 'O título do livro é obrigatório.',
            'title.min' => 'O título deve ter pelo menos :min caracteres.',
            'title.max' => 'O título não pode passar de :max caracteres.',
            'author_id.required' => 'O autor do livro é obrigatório.',
            'author_id.exists' => 'O autor selecionado é inválido.',
            'isbn.required' => 'O código ISBN do livro é obrigatório.',
            'genre.required' => 'O gênero do livro é obrigatório.',
            'genre.in' => 'Selecione um gênero válido da lista.',
            'description.required' => 'A descrição do livro é obrigatório.',
            'description.max' => 'A descrição não pode ultrapassar :max caracteres.',
            'capa.image' => 'O arquivo enviado deve ser uma imagem.',
            'capa.mimes' => 'A imagem deve estar no formato: jpeg, png, jpg ou webp.',
            'capa.max' => 'A capa não pode ser maior que 2MB.',
        ]);

        $id = Operations::decryptId($request->book_id);
        $book = Auth::user()->books()->find($id);

        if (!$book) {
            return redirect()->route('home')->with('error', 'Livro não encontrado.');
        }

        $dadosAtualizacao = [
            'title' => $request->title,
            'author_id' => $request->author_id,
            'isbn' => $request->isbn,
            'genre' => $request->genre,
            'description' => $request->description,
        ];

        if ($request->hasFile('capa')) {
            if ($book->capa && Storage::disk('public')->exists($book->capa)) {
                Storage::disk('public')->delete($book->capa);
            }
            if ($book->capa_thumbnail && Storage::disk('public')->exists($book->capa_thumbnail)) {
                Storage::disk('public')->delete($book->capa_thumbnail);
            }

            $capa = $request->file('capa');
            $caminhoOriginal = $capa->storePublicly('capas', 'public');

            $nomeWebp = pathinfo($capa->hashName(), PATHINFO_FILENAME) . '.webp';
            $caminhoThumbnail = 'capas/thumbs/' . $nomeWebp;

            // Sintaxe compatível com Intervention Image v3
            $manager = ImageManager::gd();
            $imagemThumb = $manager->read($capa)->cover(300, 400)->toWebp();
            Storage::disk('public')->put($caminhoThumbnail, (string) $imagemThumb);

            $dadosAtualizacao['capa'] = $caminhoOriginal;
            $dadosAtualizacao['capa_thumbnail'] = $caminhoThumbnail;
        }

        $book->update($dadosAtualizacao);

        return redirect()->route('home')->with('success', 'Livro atualizado com sucesso!');
    }

    public function showBook($id)
    {
        $book = Auth::user()->books()->findOrFail($id);

        return view('books.show', ['book' => $book]);
    }

    public function deletarLivro($id)
    {
        $decrypted_id = Operations::decryptId($id);

        $book = Auth::user()->books()->findOrFail($decrypted_id);
        if (!$book) {
            return redirect()->route('home');
        }
        $book->delete();
        return redirect()->route('home');
    }

    public function listDeletedBooks()
    {
        $listaExcluidos = Book::onlyTrashed()->get();
        return view('books.list_deleted', ['listaExcluidos' => $listaExcluidos]);
    }

    public function hardDeleteBook($id)
    {
        $bookId = Operations::decryptId($id);
        $book = Book::withTrashed()->find($bookId);
        if (!$book) {
            return redirect()->route('home');
        }

        if ($book->capa && Storage::disk('public')->exists($book->capa)) {
            Storage::disk('public')->delete($book->capa);
        }
        if ($book->capa_thumbnail && Storage::disk('public')->exists($book->capa_thumbnail)) {
            Storage::disk('public')->delete($book->capa_thumbnail);
        }

        $book->forceDelete();
        return redirect()->route('home');
    }

    public function restoreBook($id)
    {
        $bookId = Operations::decryptId($id);
        $book = Book::withTrashed()->find($bookId);
        if (!$book) {
            return redirect()->route('home');
        }
        $book->restore();
        return redirect()->route('home');
    }
}