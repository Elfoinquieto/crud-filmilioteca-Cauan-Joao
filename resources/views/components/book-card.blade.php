@props(['book'])

<div class="card bg-dark text-white border-secondary h-100 shadow-sm overflow-hidden">
    @if($book->capa_thumbnail)
        <a href="{{ route('detalhesLivro', $book->id) }}">
            <img src="{{ asset('storage/' . $book->capa_thumbnail) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
        </a>
    @else
        <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 140px;">
            <i class="fa-solid fa-book text-secondary display-5 opacity-25"></i>
        </div>
    @endif

    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <a href="{{ route('detalhesLivro', $book->id) }}" class="text-warning text-decoration-none fw-bold h5 mb-0 text-truncate me-2" title="{{ $book->title }}">
                {{ $book->title }}
            </a>
            
            <div class="d-flex gap-1">
                <a href="{{ route('editarLivro', ['id' => \App\Services\Operations::encryptId($book->id)]) }}" class="btn btn-sm btn-outline-warning px-2 py-0" title="Editar">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('deletarLivro', ['id' => \App\Services\Operations::encryptId($book->id)]) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja apagar este livro?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-0" title="Apagar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <p class="text-secondary small mb-0">
            <i class="fa-solid fa-user me-1"></i>{{ $book->author->name ?? 'Autor não informado' }}
        </p>
    </div>
</div>