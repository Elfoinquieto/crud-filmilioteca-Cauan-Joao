@extends('layouts.main_layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row mb-3">
                    <div class="col">
                        <p class="display-6 text-warning mb-0 fw-bold">
                            {{ isset($director) ? 'EDITAR DIRETOR' : 'NOVO DIRETOR' }}
                        </p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>

                <form action="{{ isset($director) ? route('atualizarDiretor') : route('salvarDiretor') }}" method="post">
                    @csrf
                    @if(isset($director))
                        @method('PUT')
                        <input type="hidden" name="director_id" value="{{ \App\Services\Operations::encryptId($director->id) }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-light">Nome do Diretor</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" name="name"
                            value="{{ old('name', $director->name ?? '') }}">
                        @error('name')
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