@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('components.search-form', ['route' => route('admin.device.bonus.list')])
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">보너스 지급 목록</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0 table-hover">
                            <thead>
                                <tr class="border-2 border-bottom border-primary border-0"> 
                                    <th rowspan="2" scope="col" class="ps-0 text-center border-end border-primary" style="vertical-align:middle">번호</th>
                                    <th colspan="3" scope="col" class="ps-0 text-center border-end border-primary">충전내역</th>
                                    <th colspan="6" scope="col" class="ps-0 text-center border-end border-primary">보너스내역</th>
                                    <th rowspan="2" scope="col" class="text-center"  style="vertical-align:middle">지급일자</th>
                                </tr>
                                <tr class="border-2 border-bottom border-primary border-0"> 
                                    <th scope="col" class="text-center">MID</th>
                                    <th scope="col" class="text-center">회원명</th>
                                    <th scope="col" class="text-center border-end border-primary">구매내역</th>
                                    <th scope="col" class="text-center">레벨</th>
                                    <th scope="col" class="text-center">MID</th>
                                    <th scope="col" class="text-center">회원명</th>
                                    <th scope="col" class="text-center">결제 금액</th>
                                    <th scope="col" class="text-center">보너스</th>
                                    <th scope="col" class="text-center border-end border-primary">메타웨이브 UID</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            @if($list->isNotEmpty())
                            @foreach ($list as $key => $value)
                                <tr @if(isset($value->aff)) onclick="toggleSubTable({{$key}})" @endif>
                                    <td class="bg-light text-center" scope="row" class="ps-0 fw-medium text-center">{{ $list->firstItem() + $key }}</td> 
                                    <td class="bg-light text-center">{{ $value->aff_user_id }}</td>
                                    <td class="bg-light text-center">{{ $value->aff_user_name }}</td>
                                    <td class="bg-light text-center border-primary border-end border-0">{{ number_format($value->usdt) }}</td>
                                    <td class="bg-light text-center">{{ $value->aff_user_level - $value->user_level }}</td>
                                    <td class="bg-light text-center">{{ $value->user_id }}</td>
                                    <td class="bg-light text-center">{{ $value->user_name }}</td>
                                    <td class="bg-light text-center">{{ number_format($value->part_usdt) }}</td>
                                    <td class="bg-light text-center">{{ number_format($value->bonus) }}</td>
                                    <td class="bg-light text-center border-primary border-end border-0">{{ $value->user_meta_uid }}</td>
                                    <td class="bg-light text-center">{{ $value->created_at }}</td>
                                </tr>

                                @if(isset($value->aff))
                                <tbody id="sub-table-{{ $key }}" style="display: none;">         
                                    @foreach ($value->aff as $k => $v)
                                    <tr>
                                        <td colspan="4" class="text-center border-primary border-end border-0"></td>
                                        <td class="text-center">{{ $value->aff_user_level - $v->user_level }}</td>
                                        <td class="text-center">{{ $v->user_id }}</td>
                                        <td class="text-center">{{ $v->user_name }}</td>
                                        <td class="text-center">{{ number_format($v->part_usdt) }}</td>
                                        <td class="text-center">{{ number_format($v->bonus) }}</td>
                                        <td class="text-center border-primary border-end border-0">{{ $v->user_meta_uid }}</td>
                                        <td class="border-0"></td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                                @endif
                            @endforeach
                            @else
                                <tr> 
                                    <td colspan="11" class="text-center">No Data.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        {{ $list->links('pagination::bootstrap-5') }}
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
