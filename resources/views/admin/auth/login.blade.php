@extends('admin.layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <h3 class="text-center">관리자 로그인</h3>
                        </div>
                        <form method="POST" id="loginForm" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label">이메일</label>
                                <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-4">
                                <label for="inputPassword" class="form-label">비밀번호</label>
                                <input type="password" name="password" class="form-control" id="inputPassword">
                            </div>
                            <button type="submit" class="btn btn-danger w-100 py-8 fs-4 mb-4">로그인</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<!--script src="{{ asset('js/auth/login.js') }}"></script-->
@endpush