@props(['title', 'id', 'fn', 'method'])
<!-- Modal -->
<div class="modal fade" id="deleteModal-{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="exampleModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div>
                <form action="{{ $fn }}" method="{{ $method }}">
                    <div class="modal-body">
                        <h5 class="text-white">Anda yakin untuk menghapus data ini?</h5>
                        {{ $slot }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
