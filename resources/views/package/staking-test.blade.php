@extends('layouts.master')

@section('content')
<div class="container my-5">
   
    <h2 class="mb-3 text-center">스테이킹 참여내역</h2>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="mb-2">
                <tr>
                    <th class="text-center">수량</th>
                    <th class="text-center">시간</th>
                    <th class="text-center">상세내역</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $key => $value)
                <tr>
                    <td class="text-center align-middle">{{ number_format($value->ath) }}</td>
                    <td class="text-center align-middle">{{ date_format($value->created_at, 'Y-m-d') }}</td>
                    <td class="text-center align-middle ">
                        <button class="btn btn-primary m-1" @if(isset($value->bonus) || isset($value->allowance)) onclick="toggleSubTable({{$key}})" @endif>확인</button>
                    </td>
                </tr>
                @if(isset($value->bonus) || isset($value->allowance))
                <tr class="table-hover" id="sub-table-{{ $key }}" style="display: none;">
                    <td colspan="3">
                        @if(isset($value->bonus))
                        <h5 class="mb-3">보너스 내역</h5>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">데일리</th>
                                    <th class="text-center">지급(30%)</th>
                                    <th class="text-center">락업(70%)</th>
                                    <th class="text-center">시간</th>
                                </tr>
                            </thead>
                            <tbody>         
                                @foreach ($value->bonus as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $v->daily }}</td>
                                    <td class="text-center">{{ $v->paid }}</td>
                                    <td class="text-center">{{ $v->earn }}</td>
                                    <td class="text-center">{{ date_format($v->created_at, 'Y-m-d') }}</td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        @endif
                        @if(isset($value->allowance))
                        <h5 class="mb-3r">수당내역</h5>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">산하 ID</th>
                                    <th class="text-center">데일리</th>
                                    <th class="text-center">지급(30%)</th>
                                    <th class="text-center">락업(70%)</th>
                                    <th class="text-center">시간</th>
                                </tr>
                            </thead>
                            <tbody>         
                                @foreach ($value->allowance as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $v->aff_user_id }}</td>
                                    <td class="text-center">{{ $v->daily }}</td>
                                    <td class="text-center">{{ $v->paid }}</td>
                                    <td class="text-center">{{ $v->earn }}</td>
                                    <td class="text-center">{{ date_format($v->created_at, 'Y-m-d') }}</td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $list->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
