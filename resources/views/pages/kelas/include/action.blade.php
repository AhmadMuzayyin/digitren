<div class="btn-group pull-right">
    <button data-bs-toggle="modal" data-bs-target="#editModal-{{ $model->id }}" class="btn btn-sm btn-primary">
        <span class="bx bx-edit"> </span>
    </button>

    <x-edit-modal title="Edit data kelas" id="{{ $model->id }}" fn="{{ route('kelas.update', $model->id) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <x-input type='text' name='tingkatan' id="tingkatan" label='Tingkatan' placeholder='Nama Tingkatan'
                value="{{ $model->tingkatan }}"></x-input>
        </div>
        <div class="mb-3">
            <x-input type='text' name='kelas' id="kelas" label='Kelas' placeholder='Nama Kelas'
                value="{{ $model->kelas }}"></x-input>
        </div>
        <div class="mb-3">
            <x-input type='text' name='keterangan' id="keterangan" label='Keterangan' placeholder='Keterangan'
                value="{{ $model->keterangan }}"></x-input>
        </div>
    </x-edit-modal>

    <button data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $model->id }}" class="btn btn-sm btn-danger">
        <span class="bx bx-trash"> </span>
    </button>

    <x-delete-modal title='Hapus data' id="{{ $model->id }}" fn="{{ route('kelas.destroy', $model->id) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </x-delete-modal>
</div>
