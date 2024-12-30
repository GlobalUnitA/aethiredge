@extends('layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <form method="POST" id="ajaxForm" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="account" class="form-label text-md-end">{{ __('아이디') }}</label>
                                <input id="account" type="text" class="form-control" name="account" value="{{ $account }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-md-end">{{ __('비밀번호') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <div class="form-text">영문/숫자/특수문자를 조합하여 최소 8자이상 입력하세요.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label text-md-end">{{ __('비밀번호 확인') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('비밀번호 변경') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
