@extends('layouts.master')

@section('content')
<main class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title">비밀번호 변경</h5>    
        <div></div>
    </div>
    <form method="POST" action="{{ route('profile.password.update') }}" id="ajaxForm" >
        @csrf
        <input type="hidden" name="id" value="{{ $view->user_id }}">
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered mt-5 mb-5">
                <tbody>
                    <tr>
                        <th class="text-center align-middle text-nowrap">아이디</th>
                        <td class="align-middle">{{ $view->account }}</td>
                    </tr>
                    <tr>
                        <th class="text-center align-middle text-nowrap">기존 비밀번호</th>
                        <td class="align-middle">
                            <input type="password" name="current_password"  id="inputPassword1" class="form-control required" required>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center align-middle text-nowrap">새 비밀번호</th>
                        <td class="align-middle">
                            <input type="password" name="password"  id="inputPassword1" class="form-control required" required>
                            <div class="form-text">영문/숫자/특수문자를 조합하여 최소 8자이상 입력하세요.</div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center align-middle text-nowrap">비밀번호 확인</th>
                        <td class="align-middle">
                            <input type="password" name="password_confirmation" id="inputPassword2" class="form-control required" required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-danger">비밀번호 변경</button>
        </div>
    </form>
</main>
<form method="POST" id="confirmForm" >
    @csrf
</form>
@endsection

@push('script')
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('js/postcode.js') }}"></script>
@endpush