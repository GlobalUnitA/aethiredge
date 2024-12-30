<div class="mobile-container">
    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand text-white" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
                @if( Auth::user()->is_admin == 1)
                <a class="navbar-brand text-white" href="{{ route('admin') }}" >
                    <i class="ti ti-settings"></i>
                </a>
                @else
                <div></div>
                @endif
                
            </div>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start" id="sidebar" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">메뉴</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <a class="nav-link fs-5 mt-3" href="#" onclick="showModal('error', '준비중입니다.')">
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">Language</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="{{ route('board.list', ['code' =>'notice'])}}" >
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">공지사항</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="{{ route('board.list', ['code' =>'qna'])}}" >
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">1:1문의</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="{{ route('profile') }}" >
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">회원정보 수정</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="{{ route('chart.aff') }}">
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">산하 조직도</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="{{ route('chart.ref') }}">
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">추천인 조직도</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <a class="nav-link fs-5 mt-3" href="#" onclick="showModal('error', '준비중입니다.')">
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2">
                        <div class="ms-3">추천링크</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </a>
                <form method="POST" id="logoutForm" class="nav-link fs-5 cursor-pointer mt-3" action="{{ route('logout') }}" >
                    @csrf
                    <li class="nav-item d-flex justify-content-between align-items-center border-bottom pb-2" onclick="document.getElementById('logoutForm').submit();">
                        <div class="ms-3">로그아웃</div>
                        <i class="ti ti-chevron-right"></i>
                    </li>
                </form>
            </ul>
        </div>
    </div>
</div>  
