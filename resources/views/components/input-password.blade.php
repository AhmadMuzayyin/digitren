@props(['label','id'])
<label for="{{$id}}" class="form-label">{{$label}}</label>
<div class="input-group" id="show_hide_password">
    <input type="password" class="form-control border-end-0 @error('password')
        is-invalid
    @enderror" id="{{$id}}" placeholder="Enter Password" name='password'>
    <a href="javascript:;" class="input-group-text bg-transparent">
        <i class="bx bx-hide"></i>
    </a>
    @error('password')
    <div id="{{$id}}" class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

@push('js')
<script>
    $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
</script>
@endpush
