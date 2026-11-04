@extends('layouts.main_layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Box de Boas-Vindas -->
            <div class="card bg-dark text-white border-secondary shadow mb-5 p-4 text-center">
                <h1 class="text-warning fw-bold display-5 mb-2">Filmilioteca</h1>
                <p class="text-secondary fs-5 mb-0">
                    Bem-vindo(a), <span class="text-white fw-bold">{{ auth()->user()->name ?? auth()->user()->username }}</span>! O que deseja gerenciar hoje?
                </p>
            </div>

            <!-- Seleção de Módulo -->
            <div class="row g-4">
                <!-- Módulo Livros -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white border-secondary shadow h-100 p-4 text-center">
                        <i class="fa-solid fa-book-open text-warning display-3 mb-3"></i>
                        <h3 class="fw-bold text-white mb-2">Livros</h3>
                        <p class="text-secondary small mb-4">Gerencie seus livros, autores cadastrados e acervo de leituras.</p>
                        <a href="{{ route('centralLivros') }}" class="btn btn-warning fw-bold py-2 mt-auto">
                            <i class="fa-solid fa-arrow-right me-1"></i> Acessar Livros
                        </a>
                    </div>
                </div>

                <!-- Módulo Filmes -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white border-secondary shadow h-100 p-4 text-center">
                        <i class="fa-solid fa-film text-warning display-3 mb-3"></i>
                        <h3 class="fw-bold text-white mb-2">Filmes</h3>
                        <p class="text-secondary small mb-4">Gerencie sua coleção de filmes, diretores e elenco de atores.</p>
                        <a href="{{ route('centralFilmes') }}" class="btn btn-warning fw-bold py-2 mt-auto">
                            <i class="fa-solid fa-arrow-right me-1"></i> Acessar Filmes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection