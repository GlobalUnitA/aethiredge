@extends('layouts.master')

@section('content')
<div class="container my-5">
    @if(request()->route('mode') == 'ref')
    <h2 class="mb-3 text-center">추천보너스 내역</h2>
    @else
    <h2 class="mb-3 text-center">산하보너스 내역</h2>
    @endif
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="mb-2">
                <tr>
                    <th>일자</th>
                    <th>금액</th>
                    @if(request()->route('mode') == 'ref')
                    <th>추천 ID</th>
                    @else
                    <th>산하 ID</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $key => $value)
                <tr>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->bonus }}</td>
                    <td>{{ $value->aff_user_id }}</td>
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
