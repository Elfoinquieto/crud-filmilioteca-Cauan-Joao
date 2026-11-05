@extends('layouts.main_layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">AUTORES</h2>
            <p class="text-secondary small mb-0">Autores cadastrados: </p>
        </div>
        <a href="{{ route('cadastroAutor') }}" class="btn btn-warning fw-bold">
            <i class="fa-solid fa-plus me-1"></i> ADICIONAR AUTOR
        </a>
    </div>
    <div class="row">
        @forelse($authors as $author)
            <div class="col-md-3 col-sm-6 mb-4">
                <x-author-card :author="$author" />
            </div>
        @empty
            <div class="card bg-dark text-white border-secondary shadow p-5 text-center my-4">
                <i class="fa-solid fa-book-open text-secondary display-4 mb-3 opacity-50"></i>
                <h5 class="text-secondary">Você ainda não possui nenhum ator cadastrado!</h5>
            </div>
        @endforelse
    </div>

</div>
@endsection