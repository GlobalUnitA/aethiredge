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
                            <h3 class="text-center">이메일 인증</h3>
                        </div>
                        <form method="POST" id="ajaxForm" action="{{ route('password.email') }}">
                        
                            @csrf
                            <div class="mb-3">
                                <label for="inputAccount" class="form-label">아이디</label>
                                <input type="text" name="account" class="form-control required"  id="inputAccount" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label">이메일</label>
                                <input type="email" name="email" class="form-control required"  id="inputEmail" aria-describedby="emailHelp" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">비밀번호 찾기</button>
                            </div>
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