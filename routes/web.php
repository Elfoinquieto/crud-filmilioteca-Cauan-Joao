<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\ActorController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [AuthController::class, 'index'])->name('home');

    Route::get('/autores', [AuthorController::class, 'listAuthors'])->name('listarAutores');
    Route::get('/autores/cadastrar', [AuthorController::class, 'formAuthor'])->name('cadastroAutor');
    Route::post('/autores/salvar', [AuthorController::class, 'saveAuthor'])->name('salvarAutor');
    Route::get('/autores/editar/{id}', [AuthorController::class, 'editAuthor'])->name('editarAutor');
    Route::put('/autores/atualizar', [AuthorController::class, 'updateAuthor'])->name('atualizarAutor');
    Route::get('/autores/{id}', [AuthorController::class, 'showAuthor'])->name('detalhesAutor');
    Route::delete('/autores/deletar/{id}', [AuthorController::class, 'deletarAutor'])->name('deletarAutor');

    // --- LIVROS ---
    Route::get('/livros/central', [BookController::class, 'index'])->name('centralLivros');
    Route::get('/livros', [BookController::class, 'listBooks'])->name('listarLivros');
    Route::get('/livros/cadastrar', [BookController::class, 'formBook'])->name('cadastroLivro');
    Route::post('/livros/salvar', [BookController::class, 'saveBook'])->name('salvarLivro');
    Route::get('/livros/editar/{id}', [BookController::class, 'editBook'])->name('editarLivro');
    Route::put('/livros/atualizar', [BookController::class, 'updateBook'])->name('atualizarLivro');
    Route::get('/livros/{id}', [BookController::class, 'showBook'])->name('detalhesLivro');
    Route::delete('/livros/deletar/{id}', [BookController::class, 'deletarLivro'])->name('deletarLivro');
    Route::get('/listDeletedBooks', [BookController::class, 'listDeletedBooks'])->name('listDeletedBooks');
    Route::get('/hardDelete-book/{id}', [BookController::class, 'hardDeleteBook'])->name('hardDelete');
    Route::get('/restore-book/{id}', [BookController::class, 'restoreBook'])->name('restore');

    // --- FILMES ---
    Route::get('/filmes/central', [MovieController::class, 'index'])->name('centralFilmes');
    Route::get('/filmes', [MovieController::class, 'listMovies'])->name('listarFilmes');
    Route::get('/filmes/cadastrar', [MovieController::class, 'formMovie'])->name('cadastroFilme');
    Route::post('/filmes/salvar', [MovieController::class, 'saveMovie'])->name('salvarFilme');
    Route::get('/filmes/editar/{id}', [MovieController::class, 'editMovie'])->name('editarFilme');
    Route::put('/filmes/atualizar', [MovieController::class, 'updateMovie'])->name('atualizarFilme');
    Route::get('/filmes/{id}', [MovieController::class, 'showMovie'])->name('detalhesFilme');
    Route::delete('/filmes/deletar/{id}', [MovieController::class, 'deletarFilme'])->name('deletarFilme');
    Route::get('/listDeletedMovies', [MovieController::class, 'listDeletedMovies'])->name('listDeletedMovies');
    Route::get('/hardDelete-movie/{id}', [MovieController::class, 'hardDeleteMovie'])->name('hardDeleteMovie');
    Route::get('/restore-movie/{id}', [MovieController::class, 'restoreMovie'])->name('restoreMovie');

    // --- DIRETORES ---
    Route::get('/diretores', [DirectorController::class, 'listDirectors'])->name('listarDiretores');
    Route::get('/diretores/cadastrar', [DirectorController::class, 'formDirector'])->name('cadastroDiretor');
    Route::post('/diretores/salvar', [DirectorController::class, 'saveDirector'])->name('salvarDiretor');
    Route::get('/diretores/editar/{id}', [DirectorController::class, 'editDirector'])->name('editarDiretor');
    Route::put('/diretores/atualizar', [DirectorController::class, 'updateDirector'])->name('atualizarDiretor');
    Route::delete('/diretores/deletar/{id}', [DirectorController::class, 'deletarDiretor'])->name('deletarDiretor');

    // --- ATORES ---
    Route::get('/atores', [ActorController::class, 'listActors'])->name('listarAtores');
    Route::get('/atores/cadastrar', [ActorController::class, 'formActor'])->name('cadastroAtor');
    Route::post('/atores/salvar', [ActorController::class, 'saveActor'])->name('salvarAtor');
    Route::get('/atores/editar/{id}', [ActorController::class, 'editActor'])->name('editarAtor');
    Route::put('/atores/atualizar', [ActorController::class, 'updateActor'])->name('atualizarAtor');
    Route::delete('/atores/deletar/{id}', [ActorController::class, 'deletarActor'])->name('deletarAtor');
});