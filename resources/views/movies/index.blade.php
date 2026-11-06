@extends('layouts.main_layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">FILMES</h2>
            <p class="text-secondary small mb-0">Seus Filmes: </p>
        </div>
        
        <div class="d-flex flex-column align-items-end gap-2">
            <div>
                <a href="{{ route('centralFilmes') }}" class="btn btn-outline-secondary btn-sm text-white">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
            <a href="{{ route('cadastroFilme') }}" class="btn btn-warning fw-bold">
                <i class="fa-solid fa-plus me-1"></i> ADICIONAR FILME
            </a>
        </div>
    </div>

    <div class="row">
        @forelse($movies as $movie)
            <div class="col-md-3 col-sm-6 mb-4">
                <x-movie-card :movie="$movie" />
            </div>
        @empty
            <div class="col-12">
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
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4" data-bs-theme="dark">
        {{ $movies->links() }}
    </div>

</div>
@endsection