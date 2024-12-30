<aside class="left-sidebar">
    <div>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer mt-3 me-3 text-end" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
        <div class="mt-5 mb-5">
            <p class="mb-2 text-center">어서오세요,  {{ Auth::user()->name }}님</p>
            <div class="d-flex justify-content-center align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary mx-2">Home</a>
                <form method="POST" action=" {{ route('logout') }}" >
                    @csrf
                    <button type="submit" class="btn btn-outline-danger mx-2">Logout</button>
                </form>
            </div>
        </div>
        
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">회원 관리</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.user.list') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i>
                        </span>
                        <span class="hide-menu">회원 리스트</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('chart.ref') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-sitemap"></i>
                        </span>
                        <span class="hide-menu">추천 조직도</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('chart.aff') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-sitemap-filled"></i>
                        </span>
                        <span class="hide-menu">산하 조직도</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
                    <span class="hide-menu">구매 관리</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.device.list', ['mode'=>'order']) }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-clipboard-text"></i>
                        </span>
                        <span class="hide-menu">구매 리스트</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.staking.list') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-clipboard-text"></i>
                        </span>
                        <span class="hide-menu">스테이킹 리스트</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
                    <span class="hide-menu">보너스 관리</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.device.bonus.list') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-coin"></i>
                        </span>
                        <span class="hide-menu">USDT 및 산하 보너스</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.staking.bonus.list') }}" aria-expanded="false">
                        <span>
                        <i class="ti ti-coin-filled"></i>
                        </span>
                        <span class="hide-menu">스테이킹 보너스</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
                    <span class="hide-menu">게시판 관리</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.board.list', ['code' => 'notice']) }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-bell"></i>
                        </span>
                        <span class="hide-menu">공지사항</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.board.list', ['code' => 'qna']) }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-notes"></i>
                        </span>
                        <span class="hide-menu">1:1 문의</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
                    <span class="hide-menu">관리자 기능</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" onclick="showModal('error', '준비중입니다.')" aria-expanded="false">
                        <span>
                            <i class="ti ti-language"></i>
                        </span>
                        <span class="hide-menu">언어 설정</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.board.list', ['code' => 'terms']) }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-notebook"></i>
                        </span>
                        <span class="hide-menu">서비스 약관</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" onclick="showModal('error', '준비중입니다.')" aria-expanded="false">
                        <span>
                            <i class="ti ti-settings"></i>
                        </span>
                        <span class="hide-menu">관리자 관리</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>