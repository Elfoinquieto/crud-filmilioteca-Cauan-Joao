@extends('layouts.main_layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-warning fw-bold mb-0">LIVROS</h2>
            <p class="text-secondary small mb-0">Seus Livros: </p>
        </div>
        <a href="{{ route('cadastroLivro') }}" class="btn btn-warning fw-bold">
            <i class="fa-solid fa-plus me-1"></i> ADICIONAR LIVRO
        </a>
    </div>
    <div class="row">
        @forelse($books as $book)
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

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4" data-bs-theme="dark">
        {{ $books->links() }}
    </div>

</div>
@endsection