<div class="btn-group pull-right">
    @if (isset($model->wali_santri) != false && $model->foto != 'santri.png')
        <a href="{{ route('santri.print.kts', $model->no_induk) }}" target="_blank" class="btn btn-sm btn-success">
            <span class="bx bx-printer"> </span>
        </a>
    @endif
    <a href="{{ route('santri.show', $model->id) }}" class="btn btn-sm btn-info">
        <span class="bx bx-show-alt"> </span>
    </a>

    <div class="btn-group pull-right">
        <a role="button" href="{{ route('santri.edit', $model->id) }}" class="btn btn-sm btn-primary">
            <span class="bx bx-edit"> </span>
        </a>

        <button data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $model->id }}" class="btn btn-sm btn-danger">
            <span class="bx bx-trash"> </span>
        </button>

        <x-delete-modal title='Hapus data' id="{{ $model->id }}" fn="{{ route('santri.destroy', $model->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
        </x-delete-modal>
    </div>
</div>
<script>
    console.log("{{ $model->wali_santri }}");
</script>
