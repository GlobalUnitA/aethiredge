@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('components.search-form', ['route' => route('admin.staking.bonus.list')])
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">스테이킹 지급 목록</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                            <thead>
                                <tr class="border-2 border-bottom border-primary border-0"> 
                                    <th scope="col" class="ps-0 text-center">번호</th>
                                    <th scope="col" class="text-center">MID</th>
                                    <th scope="col" class="text-center">회원명</th>
                                    <th scope="col" class="text-center">데일리</th>
                                    <th scope="col" class="text-center">지급</th>
                                    <th scope="col" class="text-center">락업</th>
                                    <th scope="col" class="text-center">지급일자</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @if($list->isNotEmpty())
                                @foreach ($list as $key => $value)
                                <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.staking.view', ['id' => $value->staking_id]) }}';">
                                    <th scope="row" class="ps-0 fw-medium text-center">{{ $list->firstItem() + $key }}</th>
                                    <td class="text-center">{{ $value->user_id }}</td>
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ number_format($value->daily) }}</td>
                                    <td class="text-center">{{ number_format($value->paid) }}</td>
                                    <td class="text-center">{{ number_format($value->earn) }}</td>
                                    <td class="text-center">{{ $value->created_at }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr> 
                                    <td colspan="7" class="text-center">No Data.</td>
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

<script>
    function toggleSubTable(key) {
        var subTable = $("#sub-table-" + key);
        subTable.stop(true, true).slideToggle(400);
    }
</script>
@endsection
