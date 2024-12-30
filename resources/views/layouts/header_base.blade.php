<div class="mobile-container">
    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand text-white" href="#">{{ config('app.name', 'Laravel') }}</a>
                <div class="profile-icon"></div>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">Language</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">공지사항</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">1:1문의</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">회원정보 수정</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">산하 조직도</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">추천인 조직도</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">추천링크</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=" {{ route('logout') }}">로그아웃</a>
                </li>
            </ul>
        </div>
    </div>
</div>