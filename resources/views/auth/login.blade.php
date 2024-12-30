@extends('layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="mb-4">
                            <h3 class="text-center">에이셔 엣지</h3>
                            <h3 class="text-center">오신 걸 환영합니다.</h3>
                        </div>
                        <form method="POST" id="ajaxForm" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="inputAccount" class="form-label">아이디</label>
                                <input type="text" name="account" class="form-control" id="inputAccount" >
                            </div>
                            <div class="mb-4">
                                <label for="inputPassword" class="form-label">비밀번호</label>
                                <input type="password" name="password" class="form-control" id="inputPassword">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a class="text-primary fw-bold" href="{{ route('register') }}">회원가입</a>
                                <a class="text-primary fw-bold" href="{{ route('password.request') }}">비밀번호 찾기</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input primary" id="flexCheckChecked" checked>
                                    <label class="form-check-label text-dark" for="flexCheckChecked">
                                        로그인 상태 유지
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">로그인</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/auth/login.js') }}"></script>
@endpush