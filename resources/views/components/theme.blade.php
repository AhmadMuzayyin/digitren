@php
    $theme = session()->get('theme');
@endphp
<div>
    <!--start switcher-->
    <div class="switcher-body">
        <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i
                class="bx bx-cog bx-spin"></i></button>
        <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false"
            tabindex="-1" id="offcanvasScrolling">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <hr>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="lightmode"
                        value="light-theme" {{ isset($theme) ? ($theme == 'light-theme' ? 'checked' : '') : '' }}>
                    <label class="form-check-label" for="lightmode">Light</label>
                </div>
                <hr>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="darkmode"
                        value="dark-theme" {{ isset($theme) ? ($theme == 'dark-theme' ? 'checked' : '') : '' }}>
                    <label class="form-check-label" for="darkmode">Dark</label>
                </div>
            </div>
        </div>
    </div>
    <!--end switcher-->
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#lightmode').click(function() {
                var newTheme = $(this).val()
                $.ajax({
                    url: "{{ url('set_theme') }}",
                    method: 'GET',
                    data: {
                        newTheme
                    },
                    success:(res)=>{
                        window.location.reload()
                    }
                })
            })
            $('#darkmode').click(function() {
                var newTheme = $(this).val()
                $.ajax({
                    url: "{{ url('set_theme') }}",
                    method: 'GET',
                    data: {
                        newTheme
                    },
                    success:(res)=>{
                        window.location.reload()
                    }
                })
            })
        })
    </script>
@endpush
