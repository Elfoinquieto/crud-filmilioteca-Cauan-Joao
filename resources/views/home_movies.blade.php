@extends('layouts.main_layout')

@section('content')
<div class="container py-4">
    <!-- Top Bar apenas com título e botão de voltar à Home -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">
                <i class="fa-solid fa-film me-2"></i>Central de Filmes
            </h2>
            <p class="text-secondary small mb-0">Gerencie sua coleção de filmes, diretores e elenco.</p>
        </div>
    </div>

    <!-- Cards de Estatísticas e Gerenciamento -->
    <div class="row g-3 mb-4">
        <!-- Filmes -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small fw-bold d-block">TOTAL DE FILMES</span>
                        <h3 class="text-warning fw-bold mb-0">{{ $moviesCount }}</h3>
                    </div>
                    <i class="fa-solid fa-video text-secondary display-6 opacity-50"></i>
                </div>
                <hr class="border-secondary my-3">
                <a href="{{ route('cadastroFilme') }}" class="btn btn-warning btn-sm fw-bold w-100">
                    <i class="fa-solid fa-plus me-1"></i> NOVO FILME
                </a>
            </div>
        </div>

        <!-- Diretores -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small fw-bold d-block">DIRETORES</span>
                        <h3 class="text-warning fw-bold mb-0">{{ $directorsCount }}</h3>
                    </div>
                    <i class="fa-solid fa-clapperboard text-secondary display-6 opacity-50"></i>
                </div>
                <hr class="border-secondary my-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('listarDiretores') }}" class="btn btn-outline-light btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-list me-1"></i> LISTAR
                    </a>
                    <a href="{{ route('cadastroDiretor') }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-plus me-1"></i> NOVO
                    </a>
                </div>
            </div>
        </div>

        <!-- Atores -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small fw-bold d-block">ATORES / ELENCO</span>
                        <h3 class="text-warning fw-bold mb-0">{{ $actorsCount }}</h3>
                    </div>
                    <i class="fa-solid fa-users text-secondary display-6 opacity-50"></i>
                </div>
                <hr class="border-secondary my-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('listarAtores') }}" class="btn btn-outline-light btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-list me-1"></i> LISTAR
                    </a>
                    <a href="{{ route('cadastroAtor') }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                        <i class="fa-solid fa-plus me-1"></i> NOVO
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista / Grid de Filmes Recentes -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-white fw-bold mb-0">Seus Filmes</h4>
        <a href="{{ route('listarFilmes') }}" class="btn btn-sm btn-outline-warning">
            Ver Todos os Filmes <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row">
        @forelse($latestMovies as $movie)
            <div class="col-md-3 col-sm-6 mb-4">
                <x-movie-card :movie="$movie" />
            </div>
        @empty
            <div class="card bg-dark text-white border-secondary shadow p-5 text-center my-4">
                <i class="fa-solid fa-film text-secondary display-4 mb-3 opacity-50"></i>
                <h5 class="text-secondary">Você ainda não possui nenhum filme cadastrado!</h5>
                <p class="text-secondary small mb-3">Comece adicionando seu primeiro filme à coleção.</p>
                <div>
                    <a href="{{ route('cadastroFilme') }}" class="btn btn-warning fw-bold px-4">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar Filme
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($latestMovies->isEmpty())
        <div class="card bg-dark text-white border-secondary shadow p-5 text-center my-4">
            <i class="fa-solid fa-film text-secondary display-4 mb-3 opacity-50"></i>
            <h5 class="text-secondary">Você ainda não possui nenhum filme cadastrado!</h5>
            <p class="text-secondary small mb-3">Comece adicionando seu primeiro filme à coleção.</p>
            <div>
                <a href="{{ route('cadastroFilme') }}" class="btn btn-warning fw-bold px-4">
                    <i class="fa-solid fa-plus me-1"></i> Cadastrar Filme
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($latestMovies as $movie)
                <div class="col-md-4">
                    <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <a href="{{ route('detalhesFilme', \App\Services\Operations::encryptId($movie->id)) }}" 
                                       class="text-warning text-decoration-none fw-bold h5 mb-0 text-truncate me-2" 
                                       title="{{ $movie->title }}">
                                        {{ $movie->title }}
                                    </a>
                                    
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('editarFilme', \App\Services\Operations::encryptId($movie->id)) }}" 
                                           class="btn btn-sm btn-outline-warning px-2 py-0" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('deletarFilme', \App\Services\Operations::encryptId($movie->id)) }}" 
                                              method="POST" class="d-inline" onsubmit="return confirm('Deseja mover este filme para a lixeira?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-0" title="Apagar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($movie->genre)
                                    <span class="badge bg-secondary text-white mb-2">{{ $movie->genre }}</span>
                                @endif

                                <p class="text-secondary small mb-1">
                                    <i class="fa-solid fa-clapperboard me-1"></i>
                                    {{ $movie->director->name ?? 'Diretor não informado' }}
                                </p>

                                @if($movie->actors->count() > 0)
                                    <p class="text-secondary small mb-0 text-truncate">
                                        <i class="fa-solid fa-users me-1"></i>
                                        {{ $movie->actors->pluck('name')->implode(', ') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection