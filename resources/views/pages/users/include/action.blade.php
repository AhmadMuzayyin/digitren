<div class="btn-group pull-right">
    <button data-bs-toggle="modal" data-bs-target="#editModal-{{ $model->id }}" class="btn btn-sm btn-primary">
        <span class="bx bx-edit"> </span>
    </button>

    <x-edit-modal title="Edit data pengguna" id="{{ $model->id }}" fn="{{ route('users.update', $model->id) }}"
        method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <x-input type='text' name='name' id="name" label='Nama Lengkap' placeholder='Nama Lengkap'
                value="{{ $model->name }}" attribute='required'></x-input>
        </div>
        <div class="mb-3">
            <x-input type='email' name='email' id="email" label='Email' placeholder='Email'
                value="{{ $model->email }}" attribute='required'></x-input>
        </div>
        <div class="mb-3">
            <x-select-option id="role_id" name="role_id" label="Jabatan">
                <option value="" selected disabled>Pilih
                    jabatan</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $model->roles->first()->id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </x-select-option>
        </div>
    </x-edit-modal>

    <button data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $model->id }}" class="btn btn-sm btn-danger">
        <span class="bx bx-trash"> </span>
    </button>
    <x-delete-modal title='Hapus data' id="{{ $model->id }}" fn="{{ route('users.destroy', $model->id) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </x-delete-modal>
</div>
