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
                        <h3 class="text-warning fw-bold mb-0">{{ $authorsCount ?? Auth::user()->authors()->count() }}</h3>
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

    @php
        $recentBooks = $latestBooks ?? Auth::user()->books()->with('author')->latest()->take(6)->get();
    @endphp

    @if($recentBooks->isEmpty())
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
    @else
        <div class="row g-3">
            @foreach($recentBooks as $book)
                <div class="col-md-4">
                    <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <a href="{{ route('detalhesLivro', \App\Services\Operations::encryptId($book->id)) }}" 
                                       class="text-warning text-decoration-none fw-bold h5 mb-0 text-truncate me-2" 
                                       title="{{ $book->title }}">
                                        {{ $book->title }}
                                    </a>
                                    
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('editarLivro', \App\Services\Operations::encryptId($book->id)) }}" 
                                           class="btn btn-sm btn-outline-warning px-2 py-0" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('deletarLivro', \App\Services\Operations::encryptId($book->id)) }}" 
                                              method="POST" class="d-inline" onsubmit="return confirm('Deseja mover este livro para a lixeira?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-0" title="Apagar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($book->genre)
                                    <span class="badge bg-secondary text-white mb-2">{{ $book->genre }}</span>
                                @endif

                                <p class="text-secondary small mb-0">
                                    <i class="fa-solid fa-user me-1"></i>
                                    {{ $book->author->name ?? 'Autor não informado' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection