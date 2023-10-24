@props(['title', 'id', 'modalSize'])
<!-- Modal -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog {{ $modalSize ?? '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
