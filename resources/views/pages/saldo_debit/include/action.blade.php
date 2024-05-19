<div class="btn-group pull-right">
    <button data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $model->id }}" class="btn btn-sm btn-danger">
        <span class="bx bx-trash"> </span>
    </button>

    <x-delete-modal title='Hapus data' id="{{ $model->id }}" fn="{{ route('saldo_debit.destroy', $model->id) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </x-delete-modal>

    {{-- History link --}}
    <a href="{{ route('saldo_debit.history', $model->santri_id) }}" role="button" class="btn btn-sm btn-primary">
        <span class="bx bx-history"> </span>
    </a>

    {{-- Export button --}}
    <form action="{{ route('saldo_debit.export', $model->santri_id) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-sm btn-info rounded-0">
            <span class="bx bx-file"> </span>
        </button>
    </form>
</div>
