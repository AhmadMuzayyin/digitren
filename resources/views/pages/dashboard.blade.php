@extends('layouts.app')

@section('title', 'Dashboard | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 d-flex">
                            <div class="card radius-15 w-100">
                                <div class="card-body">
                                    <div class="row row-cols-1 row-cols-md-3 g-3">
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto rounded-circle bg-info text-white">
                                                        <i class='bx bx-time'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $santri_aktif }}</h4>
                                                    <p class="mb-0">Santri Aktif</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto bg-wall text-white rounded-circle">
                                                        <i class='bx bx-bookmark-alt'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $santri_alumni }}</h4>
                                                    <p class="mb-0">Santri Alumni</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto bg-rose rounded-circle text-white">
                                                        <i class='bx bx-bulb'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $pengurus }}</h4>
                                                    <p class="mb-0">Pengurus</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto rounded-circle bg-danger text-white">
                                                        <i class='bx bx-line-chart'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $putra }}</h4>
                                                    <p class="mb-0">Santri Aktif Putra</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto bg-success text-white rounded-circle">
                                                        <i class='bx bx-cloud-download'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $putri }}</h4>
                                                    <p class="mb-0">Santri Aktif Putri</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card radius-15 mb-0 shadow-none border">
                                                <div class="card-body text-center">
                                                    <div class="widgets-icons mx-auto bg-primary rounded-circle text-white">
                                                        <i class='bx bx-group'></i>
                                                    </div>
                                                    <h4 class="mb-0 font-weight-bold mt-3">{{ $total_santri }}</h4>
                                                    <p class="mb-0">Total Santri</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="card radius-15 overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div>
                                            <p class="mb-0 font-weight-bold">Sessions</p>
                                            <h2 class="mb-0">501</h2>
                                        </div>
                                        <div class="ms-auto align-self-end">
                                            <p class="mb-0 font-14 text-primary"><i class='bx bxs-up-arrow-circle'></i>
                                                <span>1.01% 31 days ago</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div id="chart1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card radius-15 overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div>
                                            <p class="mb-0 font-weight-bold">Visitors</p>
                                            <h2 class="mb-0">409</h2>
                                        </div>
                                        <div class="ms-auto align-self-end">
                                            <p class="mb-0 font-14 text-success"><i class='bx bxs-up-arrow-circle'></i>
                                                <span>0.49% 31 days ago</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div id="chart2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card radius-15 overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div>
                                            <p class="mb-0 font-weight-bold">Page Views</p>
                                            <h2 class="mb-0">2,346</h2>
                                        </div>
                                        <div class="ms-auto align-self-end">
                                            <p class="mb-0 font-14 text-danger"><i class='bx bxs-down-arrow-circle'></i>
                                                <span>130.68% 31 days
                                                    ago</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div id="chart3"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="row row-cols-1 row-cols-lg-3">
                        <div class="col d-flex">
                            <div class="card radius-15 w-100">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="mb-0">Santri Putra Sering Keluar </h5>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/chrome.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">587</h6>
                                            <p class="mb-0">Chrome</p>
                                        </div>
                                        <p class="mb-0 ms-auto">24.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/firefox.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">358</h6>
                                            <p class="mb-0">Firefox</p>
                                        </div>
                                        <p class="mb-0 ms-auto">12.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/edge.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">867</h6>
                                            <p class="mb-0">Edge</p>
                                        </div>
                                        <p class="mb-0 ms-auto">24.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/opera.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">752</h6>
                                            <p class="mb-0">Opera</p>
                                        </div>
                                        <p class="mb-0 ms-auto">27.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/safari.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">586</h6>
                                            <p class="mb-0">Safari</p>
                                        </div>
                                        <p class="mb-0 ms-auto">14.5%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <div class="card radius-15 w-100">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="mb-0">Santri Putri Sering Keluar </h5>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/chrome.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">587</h6>
                                            <p class="mb-0">Chrome</p>
                                        </div>
                                        <p class="mb-0 ms-auto">24.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/firefox.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">358</h6>
                                            <p class="mb-0">Firefox</p>
                                        </div>
                                        <p class="mb-0 ms-auto">12.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/edge.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">867</h6>
                                            <p class="mb-0">Edge</p>
                                        </div>
                                        <p class="mb-0 ms-auto">24.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/opera.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">752</h6>
                                            <p class="mb-0">Opera</p>
                                        </div>
                                        <p class="mb-0 ms-auto">27.3%</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="assets/images/icons/safari.png" width="35" height="35"
                                                alt="" />
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0">586</h6>
                                            <p class="mb-0">Safari</p>
                                        </div>
                                        <p class="mb-0 ms-auto">14.5%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex">
                            <div class="card radius-15 w-100">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5 class="mb-0">Pengunjung Berdasarkan Jenis Kelamin </h5>
                                    </div>
                                    <hr />
                                    <div id="chart6"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!--end page-content-wrapper-->
        </div>
        <!--end page-wrapper-->
    </div>
@endsection
