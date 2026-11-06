@extends('layouts.main_layout')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm text-white">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row">

        @if($book->capa)
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white border-secondary shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $book->capa) }}" class="img-fluid w-100 rounded" alt="{{ $book->title }}" style="max-height: 420px; object-fit: cover;">
                </div>
            </div>
        @endif

        <div class="{{ $book->capa ? 'col-md-5' : 'col-md-8' }} mb-4">
            <div class="card bg-dark text-white border-secondary h-100 shadow">
                <div class="card-body p-4">
                    <span class="badge bg-warning text-dark mb-2">{{ $book->genre ?? 'Gênero não informado' }}</span>
                    <h2 class="text-warning fw-bold mb-3">{{ $book->title }}</h2>
                    <hr class="border-secondary mb-4">
                    <h5 class="fw-bold text-secondary mb-2">SINOPSE / DESCRIÇÃO</h5>
                    <p class="text-light" style="white-space: pre-line;">{{ $book->description ?? 'Nenhuma descrição informada.' }}</p>
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
                        <strong class="text-secondary d-block small">AUTOR</strong>
                        <span>{{ $book->author->name ?? 'Não informado' }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary">
                        <strong class="text-secondary d-block small">ISBN</strong>
                        <span>{{ $book->isbn ?? 'Não informado' }}</span>
                    </li>
                </ul>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('editarLivro', $book->id) }}" class="btn btn-warning fw-bold flex-fill">
                    <i class="fa-solid fa-pen-to-square me-1"></i> EDITAR
                </a>
                <form action="{{ route('deletarLivro', $book->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Deseja apagar este livro?')">
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