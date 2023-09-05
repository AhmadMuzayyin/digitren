@props(['url', 'path'])
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{$path}}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{$url}}">
                        <i class='bx bx-home-alt'></i>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$path}}</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
