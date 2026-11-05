@extends('layouts.main_layout')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card bg-dark text-white border-secondary h-100 shadow">
                <div class="card-body p-4">
                    <h2 class="text-warning fw-bold mb-3">{{ $actor->name }}</h2>
                    <hr class="border-secondary mb-4">
                    <h5 class="fw-bold text-secondary mb-3">FILMOGRAFIA / FILMES</h5>

                    <div class="row">
                        @forelse($actor->movies ?? [] as $movie)
                            <div class="col-md-6 mb-3">
                                <x-movie-card :movie="$movie" />
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-secondary mb-0">Nenhum filme vinculado a este ator/atriz.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white border-secondary shadow mb-3">
                <div class="card-header border-secondary fw-bold text-warning">
                    INFORMAÇÕES
                </div>
                <ul class="list-group list-group-flush bg-dark">
                    <li class="list-group-item bg-dark text-white border-secondary">
                        <strong class="text-secondary d-block small">NOME COMPLETO</strong>
                        <span>{{ $actor->name }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary">
                        <strong class="text-secondary d-block small">PARTICIPAÇÕES EM FILMES</strong>
                        <span>{{ $actor->movies ? $actor->movies->count() : 0 }}</span>
                    </li>
                </ul>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('editarAtor', \App\Services\Operations::encryptId($actor->id)) }}" class="btn btn-warning fw-bold flex-fill">
                    <i class="fa-solid fa-pen-to-square me-1"></i> EDITAR
                </a>
                <form action="{{ route('deletarAtor', \App\Services\Operations::encryptId($actor->id)) }}" method="POST" class="flex-fill" onsubmit="return confirm('Deseja apagar este ator?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger fw-bold w-100">
                        <i class="fa-solid fa-trash me-1"></i> APAGAR
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection