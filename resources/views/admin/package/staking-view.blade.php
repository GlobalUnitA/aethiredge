@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">스테이킹 신청 상세 정보</h5>    
                    <div>{{ $view->created_at }}</div>
                </div>
                <form method="POST" id="ajaxForm" action="{{ route('admin.staking.update') }}" >
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
                                <th class="text-center align-middle">ATH 수량</th>
                                <td><input type="text" name="usdt" id="ath" value="{{ $view->ath }}" class="form-control"></td>
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
                        <a href="{{ route('admin.staking.list') }}" class="btn btn-secondary">목록</a>
                        <button type="submit" class="btn btn-danger">수정</button>
                    </div>
                </form>
            </div>
        </div>

        @if($view->status == 'p')
        <div class="card p-3">
            <div class="card-head mt-5">
                <h5 class="card-title">보너스 수동 지급</h5>    
            </div>
            <hr>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0"> 
                                <th scope="col" class="ps-0 text-center">번호</th>
                                <th scope="col" class="text-center">MID</th>
                                <th scope="col" class="text-center">데일리</th>
                                <th scope="col" class="text-center">지급</th>
                                <th scope="col" class="text-center">락업</th>
                                <th scope="col" class="text-center" >지급일자</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @if(isset($view->bonus))
                            @foreach ($view->bonus as $key => $value)
                            <tr style="cursor:pointer;">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $value->user_id }}</td>
                                <td class="text-center">{{ number_format($value->daily) }}</td>
                                <td class="text-center">{{ number_format($value->paid) }}</td>
                                <td class="text-center">{{ number_format($value->earn) }}</td>
                                <td class="text-center">{{ $value->created_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger" onclick="deleteBonus({{ $value->id }})">삭제</button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="6">No Data.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <hr>
                    <form method="POST" id="bonusForm" action="{{ route('admin.staking.test') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $view->user_id }}" >
                        <input type="hidden" name="staking_id" value="{{ $view->id }}" >
                        <div class="d-flex align-items-center mb-2">
                            <div class="col-md-2 me-2">
                                <label for="input-1" class="form-label">데일리</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-2" class="form-label">지급</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-3" class="form-label">락업</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-3" class="form-label">일자</label>
                            </div>
                            <div class="col-md-2 me-2"></div>
                        </div>
                        <div id="input_bonus">
                            <div class="d-flex align-items-center mb-3">
                                <input type="hidden" name="aff_user_id[]" value="0" />
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-1" name="daily[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-2" name="paid[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-3" name="earn[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="date" id="input-3" name="created_at[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <button type="button" id="addBonusBtn" class="btn btn-success">+ 추가</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="button" id="bonusBtn" class="btn btn-primary w-100">보너스 지급</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card p-3">
            <div class="card-head mt-5">
                <h5 class="card-title">수당 수동 지급</h5>    
            </div>
            <hr>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0"> 
                                <th scope="col" class="ps-0 text-center">번호</th>
                                <th scope="col" class="text-center">MID</th>
                                <th scope="col" class="text-center">산하 ID</th>
                                <th scope="col" class="text-center">데일리</th>
                                <th scope="col" class="text-center">지급</th>
                                <th scope="col" class="text-center">락업</th>
                                <th scope="col" class="text-center" >지급일자</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @if(isset($view->allowance))
                            @foreach ($view->allowance as $key => $value)
                            <tr style="cursor:pointer;">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $value->user_id }}</td>
                                <td class="text-center">{{ $value->aff_user_id }}</td>
                                <td class="text-center">{{ number_format($value->daily) }}</td>
                                <td class="text-center">{{ number_format($value->paid) }}</td>
                                <td class="text-center">{{ number_format($value->earn) }}</td>
                                <td class="text-center">{{ $value->created_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger" onclick="deleteBonus({{ $value->id }})">삭제</button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="7">No Data.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <hr>
                    <form method="POST" id="allowanceForm" action="{{ route('admin.staking.test') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $view->user_id }}" >
                        <input type="hidden" name="staking_id" value="{{ $view->id }}" >
                        <div class="d-flex align-items-center mb-2">
                            <div class="col-md-2 me-2">
                                <label for="input-1" class="form-label">산하 ID</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-1" class="form-label">데일리</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-2" class="form-label">지급</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-3" class="form-label">락업</label>
                            </div>
                            <div class="col-md-2 me-2">
                                <label for="input-3" class="form-label">일자</label>
                            </div>
                            <div class="col-md-2 me-2"></div>
                        </div>
                        <div id="input_allowance">
                            <div class="d-flex align-items-center mb-3">
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-1" name="aff_user_id[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-1" name="daily[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-2" name="paid[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="number" id="input-3" name="earn[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <input type="date" id="input-3" name="created_at[]" class="form-control">
                                </div>
                                <div class="col-md-2 me-2">
                                    <button type="button" id="addAllowanceBtn" class="btn btn-success">+ 추가</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="button" id="allowanceBtn" class="btn btn-primary w-100">수당 지급</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<form method="POST" id="statusForm" action="{{ route('admin.staking.status') }}" >
    @csrf
</form>
<form method="POST" id="deleteForm" action="{{ route('admin.staking.delete') }}" >
    @csrf
</form>
@endsection

@push('script')
<script src="{{ asset('js/admin/staking.js') }}"></script>
@endpush