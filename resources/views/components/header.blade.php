<div>
    <header class="top-header">
        <nav class="navbar navbar-expand">
            <div class="left-topbar d-flex align-items-center">
                <a href="javascript:;" class="toggle-btn"> <i class="bx bx-menu"></i>
                </a>
            </div>
            <div class="right-topbar ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="javascript:;"
                            data-bs-toggle="dropdown"> <span class="msg-count">0</span>
                            <i class="bx bx-comment-detail vertical-align-middle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <h6 class="msg-header-title">0 New</h6>
                                    <p class="msg-header-subtitle">Application Messages</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                {{-- <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="{{ url('assets/images/avatars/avatar-1.png') }}"
                                                class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5
                                                    sec
                                                    ago</span></h6>
                                            <p class="msg-info">The standard chunk of lorem</p>
                                        </div>
                                    </div>
                                </a> --}}
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Messages</div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                            href="javascript:;" data-bs-toggle="dropdown"> <i
                                class="bx bx-bell vertical-align-middle"></i>
                            <span class="msg-count">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <h6 class="msg-header-title">0 New</h6>
                                    <p class="msg-header-subtitle">Application Notifications</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                {{-- <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">New Customers<span class="msg-time float-end">14
                                                    Sec
                                                    ago</span></h6>
                                            <p class="msg-info">5 new user registered</p>
                                        </div>
                                    </div>
                                </a> --}}
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Notifications</div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-user-profile">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                            data-bs-toggle="dropdown">
                            <div class="d-flex user-box align-items-center">
                                <div class="user-info">
                                    <p class="user-name mb-0">{{ ucfirst(auth()->user()->name) }}</p>
                                    <p class="designattion mb-0">Online</p>
                                </div>
                                <img src="{{ url('assets/images/avatars/avatar-1.png') }}" class="user-img"
                                    alt="user avatar">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('profil.show', auth()->user()->id) }}"><i
                                    class="bx bx-user"></i><span>Profile</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('setting.index') }}"><i
                                    class="bx bx-cog"></i><span>Settings</span>
                            </a>
                            <div class="dropdown-divider mb-0"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" method='post' style="cursor: pointer" class="dropdown-item">
                                    <i class="bx bx-power-off"></i><span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</div>
