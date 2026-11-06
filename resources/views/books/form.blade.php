@extends('layouts.main_layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row mb-3">
                    <div class="col">
                        <p class="display-6 text-warning mb-0 fw-bold">
                            {{ isset($book) ? 'EDITAR LIVRO' : 'NOVO LIVRO' }}
                        </p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>

                <form action="{{ isset($book) ? route('atualizarLivro') : route('salvarLivro') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if(isset($book))
                        @method('PUT')
                        <input type="hidden" name="book_id" value="{{ \App\Services\Operations::encryptId($book->id) }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-light">Título do Livro</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" name="title"
                            value="{{ old('title', $book->title ?? '') }}">
                        @error('title')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Imagem da Capa</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" name="capa" accept="image/*">
                        @error('capa')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        @if(isset($book) && $book->capa_thumbnail)
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <small class="text-secondary">Capa atual:</small>
                                <img src="{{ asset('storage/' . $book->capa_thumbnail) }}" alt="Capa Atual" class="rounded border border-secondary" style="height: 60px; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Autor</label>
                        <select class="form-select bg-dark text-white border-secondary" name="author_id">
                            <option value="">Selecione um autor...</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('author_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">ISBN</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="isbn"
                                value="{{ old('isbn', $book->isbn ?? '') }}">
                            @error('isbn')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Gênero</label>
                            <select class="form-select bg-dark text-white border-secondary" name="genre">
                                <option value="">Selecione o gênero...</option>
                                @foreach(App\Models\Book::GENRES as $genre)
                                    <option value="{{ $genre }}" {{ old('genre', $book->genre ?? '') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Descrição / Sinopse</label>
                        <textarea class="form-control bg-dark text-white border-secondary" name="description"
                            rows="4">{{ old('description', $book->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 me-2">
                                <i class="fa-solid fa-ban me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning px-5 fw-bold">
                                <i class="fa-regular fa-circle-check me-1"></i> Salvar
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection