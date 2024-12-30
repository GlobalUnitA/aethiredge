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
                                <h3 class="text-center">회원가입</h3>
                            </div>
                            <form method="POST" action="{{ route('register') }}" id="ajaxForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="inputAccount" class="form-label required">아이디</label>
                                    <input type="text" name="account" id="inputAccount" class="form-control required" required>
                                </div>
                                <div class="mb-4">
                                    <label for="inputPassword1" class="form-label required">비밀번호</label>
                                    <input type="password" name="password"  id="inputPassword1" class="form-control required" required>
                                    <div class="form-text">영문/숫자/특수문자를 조합하여 최소 8자이상 입력하세요.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="inputPassword2" class="form-label required">비밀번호 확인</label>
                                    <input type="password" name="password_confirmation" id="inputPassword2" class="form-control required" required>
                                </div>
                                <div class="mb-4">
                                    <label for="inputName" class="form-label required">이름</label>
                                    <input type="text" name="name" id="inputName" class="form-control required" required>
                                </div>
                                <div class="mb-4">
                                    <label for="inputPhone" class="form-label required">휴대폰</label>
                                    <input type="text" name="phone" id="inputPhone" class="form-control required" required>
                                </div>
                                <div class="mb-4">
                                    <label for="inputEmail" class="form-label">이메일</label>
                                    <input type="email" name="email" id="inputEmail" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="inputMetaUid" class="form-label">메타웨이브 UID</label>
                                    <input type="text" name="metaUid" id="inputMetaUid" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="inputParentId" class="form-label required">추천인 에이셔 MID</label>
                                    <input type="text" name="parentId" id="inputParentId" @if($mid)value="{{ $mid }}"@endif class="form-control required" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">가입하기</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('register.emailCheck') }}"  id="emailCheckForm" >
    @csrf
    <input type="hidden" name="email" id="inputEmailCheck">
</form>
@endsection

@push('script')
<script src="{{ asset('js/auth/register.js') }}"></script>
@endpush