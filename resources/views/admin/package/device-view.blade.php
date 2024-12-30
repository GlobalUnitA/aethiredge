@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">구매 신청 상세 정보</h5>    
                    <div>{{ $view->created_at }}</div>
                </div>
                <form method="POST" id="ajaxForm" action="{{ route('admin.device.update') }}" >
                    @csrf
                    <input type="hidden" name="id" value="{{ $view->id }}">
                    <hr>
                    <table class="table table-bordered mt-5 mb-5">
                        <tbody>
                            <tr>
                                <th class="text-center align-middle">아이디</th>
                                <td class="align-middle">{{ $view->account }}</td>
                                <th class="text-center align-middle">이름</th>
                                <td class="align-middle">{{ $view->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">전화번호</th>
                                <td class="align-middle">{{ $view->phone }}</td>
                                <th class="text-center align-middle">TXID</th>
                                <td class="align-middle">{{ $view->txid }}</td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">상태</th>
                                <td class="align-middle">
                                    @if($view->status == 'p')
                                    <span>승인</span>
                                    @elseif($view->status == 'c')
                                    <span>취소</span>
                                    @else
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>미승인</span>
                                        <div class="d-flex justify-content-end">
                                            <a id="approvalBtn" class="btn btn-primary" style="margin-right:10px;">승인</a>
                                            <a id="cancelBtn" class="btn btn-danger">취소</a>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" name="status" value="{{ $view->status }}">
                                </td>
                                <th class="text-center align-middle">USDT 금액</th>
                                <td><input type="text" name="usdt" id="usdt" value="{{ $view->usdt }}" class="form-control"></td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">이미지</th>
                                <td colspan=3 class="align-middle">
                                    <div class="text-center align-middle">
                                        @if($view->image_urls)
                                            @foreach($view->image_urls as $val)
                                                <a href="{{ $val }}">
                                                    <img src="{{ $val }}" class="img-fluid" style="height:300px">
                                                </a>
                                            @endforeach
                                        @else
                                            <span>이미지가 없습니다.</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">메모</th>
                                <td colspan=3 class="align-middle">
                                    <textarea name="memo" class="form-control" id="memo" rows="12" >{{ $view->memo }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.device.list', ['mode'=>'order']) }}" class="btn btn-secondary">목록</a>
                        <button type="submit" class="btn btn-danger">수정</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<form method="POST" id="statusForm" action="{{ route('admin.device.status') }}" >
    @csrf
</form>
@endsection

@push('script')
<script src="{{ asset('js/admin/device.js') }}"></script>
@endpush