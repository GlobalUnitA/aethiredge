@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('components.search-form', ['route' => route('admin.device.list', request()->query())])
                <ul class="nav nav-tabs mt-3" id="tableTabs" role="tablist" >
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('admin.device.list', array_merge(request()->query(), ['mode' => 'order'])) }}" class="nav-link  {{ Request('mode') == 'order' ? 'active' : '' }}">구매 신청</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('admin.device.list', array_merge(request()->query(), ['mode' => 'cancel'])) }}" class="nav-link  {{ Request('mode') == 'cancel' ? 'active' : '' }}">구매 취소<a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title"></h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                            <thead>
                                <tr class="border-2 border-bottom border-primary border-0"> 
                                    <th scope="col" class="ps-0 text-center">번호</th>
                                    <th scope="col" class="text-center">아이디</th>
                                    <th scope="col" class="text-center">회원명</th>
                                    <th scope="col" class="text-center">연락처</th>
                                    <th scope="col" class="text-center">USDT 금액</th>
                                    <th scope="col" class="text-center">상태</th>
                                    <th scope="col" class="text-center">메모</th>
                                    <th scope="col" class="text-center">구매일자</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @if($list->isNotEmpty())
                                @foreach ($list as $key => $value)
                                <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.device.view', ['id' => $value->id]) }}';">
                                    <th scope="row" class="ps-0 fw-medium text-center">{{ $list->firstItem() + $key }}</th>
                                    <td class="text-center">{{ $value->account }}</td>
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center">{{ number_format($value->usdt) }}</td>
                                    <td class="text-center">
                                        @if($value->status == 'o')
                                            미승인
                                        @elseif($value->status == 'p')
                                            승인
                                        @elseif($value->status == 'c')
                                            취소
                                        @elseif($value->status == 'r')
                                            환불
                                        @else
                                            오류
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $value->memo }}</td>
                                    <td class="text-center">{{ $value->created_at }}</td>
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
                    <div class="d-flex justify-content-center mt-5">
                        {{ $list->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection