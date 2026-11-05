@extends('layouts.main_layout')

@section('content')
<div class="container py-4">
    <!-- Top Bar apenas com título e botão de voltar à Home -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">
                <i class="fa-solid fa-book-open me-2"></i>Central de Livros
            </h2>
            <p class="text-secondary small mb-0">Gerencie sua coleção de livros e autores cadastrados.</p>
        </div>
    </div>

    <!-- Cards de Estatísticas e Gerenciamento -->
    <div class="row g-3 mb-4">
        <!-- Livros -->
        <div class="col-md-6">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small fw-bold d-block">TOTAL DE LIVROS</span>
                        <h3 class="text-warning fw-bold mb-0">{{ $booksCount ?? Auth::user()->books()->count() }}</h3>
                    </div>
                    <i class="fa-solid fa-book text-secondary display-6 opacity-50"></i>
                </div>
                <hr class="border-secondary my-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('cadastroLivro') }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-plus me-1"></i> NOVO LIVRO
                    </a>
                </div>
            </div>
        </div>

        <!-- Autores -->
        <div class="col-md-6">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small fw-bold d-block">AUTORES</span>
                        <h3 class="text-warning fw-bold mb-0">{{ $authorsCount }}</h3>
                    </div>
                    <i class="fa-solid fa-user-pen text-secondary display-6 opacity-50"></i>
                </div>
                <hr class="border-secondary my-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('listarAutores') }}" class="btn btn-outline-light btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-list me-1"></i> LISTAR AUTORES
                    </a>
                    <a href="{{ route('cadastroAutor') }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-plus me-1"></i> NOVO AUTOR
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista / Grid de Livros Recentes -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-white fw-bold mb-0">Seus Livros Recentes</h4>
        <a href="{{ route('listarLivros') }}" class="btn btn-sm btn-outline-warning">
            Ver Todos os Livros <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row">
        @forelse($latestBooks as $book)
            <div class="col-md-3 col-sm-6 mb-4">
                <x-book-card :book="$book" />
            </div>
        @empty
            <div class="card bg-dark text-white border-secondary shadow p-5 text-center my-4">
                <i class="fa-solid fa-book-open text-secondary display-4 mb-3 opacity-50"></i>
                <h5 class="text-secondary">Você ainda não possui nenhum livro cadastrado!</h5>
                <p class="text-secondary small mb-3">Comece adicionando seu primeiro livro ao seu acervo.</p>
                <div>
                    <a href="{{ route('cadastroLivro') }}" class="btn btn-warning fw-bold px-4">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar Livro
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection