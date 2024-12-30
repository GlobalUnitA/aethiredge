@extends('layouts.master')

@section('content')
<main class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title">회원 정보</h5>    
        <div></div>
    </div>
    <form method="POST" action="{{ route('profile.update') }}" id="ajaxForm" >
        @csrf
        <input type="hidden" name="id" value="{{ $view->user_id }}">
        <hr>
        <table class="table table-bordered mt-5 mb-5">
            <tbody>
                <tr>
                    <th class="text-center align-middle">이름</th>
                    <td class="align-middle">{{ $view->name }}</td>
                </tr>
                <tr>
                    <th class="text-center align-middle">비밀번호</th>
                    <td class="align-middle"><a href="{{ route('profile.password') }}" class="btn btn-outline-info btn-sm">비밀번호 변경</a></td>
                </tr>
                <tr>
                    <th class="text-center align-middle">이메일</th>
                    <td class="align-middle">
                        <input type="text" name="email" value="{{ $view->email }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="text-center align-middle">전화번호</th>
                    <td class="align-middle">
                        <input type="text" name="phone" value="{{ $view->phone }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="text-center align-middle">메타웨이브 UID</th>
                    <td class="align-middle">
                        <input type="text" name="meta_uid" value="{{ $view->meta_uid }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="text-center align-middle">통관번호</th>
                    <td class="align-middle">
                        <input type="text" name="pcc" value="{{ $view->pcc }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th class="text-center align-middle">주소</th>           
                    <td>
                        <div class="d-flex mb-3 align-middle">
                            <div class="col-6 me-2">
                                <input type="text" name="post_code" id="postcode" placeholder="우편번호"  class="form-control" value="{{ $view->post_code }}">
                            </div>
                            <button type="button" onclick="daumPostcode()" class="btn btn-outline-primary btn-sm me-2">우편번호 찾기</button>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address" id="address" placeholder="주소"  class="form-control me-2" value="{{ $view->address }}">
                        </div>
                        <div>
                            <input type="text" name="detail_address" id="detailAddress" placeholder="상세주소"  class="form-control" value="{{ $view->detail_address }}">
                        </div>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <hr>
        <div class="d-flex justify-content-end mb-5">
            <button type="submit" class="btn btn-danger">수정</button>
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