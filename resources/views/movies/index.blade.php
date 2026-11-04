@extends('layouts.main_layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">FILMES</h2>
            <p class="text-secondary small mb-0">Seus Filmes: </p>
        </div>
        <a href="{{ route('cadastroFilme') }}" class="btn btn-warning fw-bold">
            <i class="fa-solid fa-plus me-1"></i> ADICIONAR FILME
        </a>
    </div>
    <div class="row">
        @forelse($movies as $movie)
            <div class="col-md-3 col-sm-6 mb-4">
                <x-movie-card :movie="$movie" />
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-dark text-secondary text-center border-secondary py-5 mb-0">
                    <i class="fa-solid fa-film fa-2x mb-3 text-warning"></i>
                    <p class="mb-2">Nenhum filme encontrado.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection