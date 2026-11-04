<div class="card bg-dark text-white border-secondary shadow mb-3">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h4 class="text-warning fw-bold mb-1">{{ $excluido->title }}</h4>
                <p class="text-secondary small mb-0">
                    <i class="fa-solid fa-clapperboard me-1"></i>{{ $excluido->director->name ?? 'Diretor não informado' }}
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('restoreMovie', ['id' => \App\Services\Operations::encryptId($excluido->id)]) }}"
                   class="btn btn-outline-warning btn-sm fw-bold" title="Restaurar filme">
                    <i class="fa-solid fa-arrow-rotate-left me-1"></i> RESTAURAR
                </a>
                <a href="{{ route('hardDeleteMovie', ['id' => \App\Services\Operations::encryptId($excluido->id)]) }}"
                   class="btn btn-outline-danger btn-sm fw-bold"
                   onclick="return confirm('Deseja excluir permanentemente este filme?')" title="Excluir permanentemente">
                    <i class="fa-regular fa-trash-can me-1"></i> EXCLUIR DEFINITIVAMENTE
                </a>
            </div>
        </div>

        <hr class="border-secondary my-3">

        <div class="d-flex flex-wrap gap-4 text-secondary small">
            <span>
                <strong class="text-white-50">Criado em:</strong> {{ $excluido->created_at->format('d/m/Y H:i') }}
            </span>

            @if ($excluido->created_at != $excluido->updated_at)
                <span>
                    <strong class="text-white-50">Atualizado em:</strong> {{ $excluido->updated_at->format('d/m/Y H:i') }}
                </span>
            @endif

            <span class="text-danger-emphasis">
                <strong class="text-danger">Deletado em:</strong> {{ $excluido->deleted_at->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
</div>