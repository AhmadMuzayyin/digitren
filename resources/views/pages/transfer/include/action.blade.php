<div class="btn-group pull-right">
    <button data-bs-toggle="modal" data-bs-target="#editModal-{{ $model->id }}" class="btn btn-sm btn-primary">
        <span class="bx bx-edit"> </span>
    </button>
    {{-- <x-edit-modal title="Edit data kamar" id="{{ $model->id }}" fn="{{ route('transfer.update', $model->id) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <x-input type='text' name='nama' id="nama" label='Nama Kamar' placeholder='Nama Kamar'
                value="{{ $model->nama }}"></x-input>
        </div>
        <div class="mb-3">
            <x-input type='text' name='blok' id="blok" label='Blok' placeholder='Nama Blok'
                value="{{ $model->blok }}"></x-input>
        </div>
        <div class="mb-3">
            <x-input type='number' name='jumlah_santri' id="jumlah_santri" label='Jumlah Santri'
                placeholder='Jumlah Santri' value="{{ $model->jumlah_santri }}"></x-input>
        </div>
        <div class="mb-3">
            <x-input type='number' name='maksimal_santri' id="maksimal_santri" label='Maksimal Santri'
                placeholder='Maksimal Santri' value="{{ $model->maksimal_santri }}"></x-input>
        </div>
    </x-edit-modal>

    <button data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $model->id }}" class="btn btn-sm btn-danger">
        <span class="bx bx-trash"> </span>
    </button>

    <x-delete-modal title='Hapus data' id="{{ $model->id }}" fn="{{ route('transfer.destroy', $model->id) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </x-delete-modal> --}}
</div>
