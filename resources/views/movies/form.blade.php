@extends('layouts.main_layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row mb-3">
                    <div class="col">
                        <p class="display-6 text-warning mb-0 fw-bold">
                            {{ isset($movie) ? 'EDITAR FILME' : 'NOVO FILME' }}
                        </p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('centralFilmes') }}" class="btn btn-outline-danger">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>

                <form action="{{ isset($movie) ? route('atualizarFilme') : route('salvarFilme') }}" method="post">
                    @csrf
                    @if(isset($movie))
                        @method('PUT')
                        <input type="hidden" name="movie_id" value="{{ \App\Services\Operations::encryptId($movie->id) }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-light">Título do Filme</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" name="title"
                            value="{{ old('title', $movie->title ?? '') }}">
                        @error('title')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Diretor</label>
                        <select class="form-select bg-dark text-white border-secondary" name="director_id">
                            <option value="">Selecione um diretor...</option>
                            @foreach($directors as $director)
                                <option value="{{ $director->id }}" {{ old('director_id', $movie->director_id ?? '') == $director->id ? 'selected' : '' }}>
                                    {{ $director->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('director_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Gênero</label>
                            <select class="form-select bg-dark text-white border-secondary" name="genre">
                                <option value="">Selecione o gênero...</option>
                                @foreach(App\Models\Movie::GENRES as $genre)
                                    <option value="{{ $genre }}" {{ old('genre', $movie->genre ?? '') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Atores / Elenco (Pressione Ctrl para selecionar múltiplos)</label>
                            <select class="form-select bg-dark text-white border-secondary" name="actors[]" multiple size="4">
                                @php
                                    $selectedActors = old('actors', isset($movie) ? $movie->actors->pluck('id')->toArray() : []);
                                @endphp
                                @foreach($actors as $actor)
                                    <option value="{{ $actor->id }}" {{ in_array($actor->id, $selectedActors) ? 'selected' : '' }}>
                                        {{ $actor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('actors')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Descrição / Sinopse</label>
                        <textarea class="form-control bg-dark text-white border-secondary" name="description"
                            rows="4">{{ old('description', $movie->description ?? '') }}</textarea>
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