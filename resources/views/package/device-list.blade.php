@extends('layouts.master')

@section('content')
<div class="container my-5">
   
    <h2 class="mb-3 text-center">구매 내역</h2>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="mb-2">
                <tr>
                    <th>일자</th>
                    <th>상태</th>
                    <th>수량</th>
                    <th>금액</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $key => $value)
                <tr>
                    <td>{{ $value->created_at }}</td>
                    <td>
                        @if($value->status == 'p')
                        승인
                        @elseif($value->status == 'c')
                        취소
                        @else
                        미승인
                        @endif
                    </td>
                    <td>{{ number_format($value->ea) }} EA</td>
                    <td>{{ number_format($value->usdt) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $list->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
