@extends('layouts.master')

@section('content')

<main class="container-fluid py-5">
    <div class="mb-3 d-flex justify-content-between">
        <h5 class="card-title">{{ $board->board_name }}</h5>
        @if($board->board_code == 'qna')
        <a class="btn btn-primary" href="{{ route('board.view', ['code' => $board->board_code, 'mode' => 'write']) }}">문의하기</a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
            <thead>
                <tr class="border-2 border-bottom border-primary border-0"> 
                    <th scope="col" class="ps-0 text-center">번호</th>
                    <th scope="col" class="text-center">제목</th>
                    <th scope="col" class="text-center">작성일</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if($list->isNotEmpty())
                @foreach ($list as $key => $value)
                <tr style="cursor:pointer;" onclick="window.location='{{ route('board.view', ['code' => $board->board_code, 'mode' => 'view', 'id' => $value->id]) }}';">
                    <th scope="row" class="ps-0 fw-medium text-center">{{ $list->firstItem() + $key }}</th>
                    <td class="text-center">{{ $value->subject }}</td>
                    <td class="text-center">{{ $value->created_at->format('Y-m-d') }}</td>
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

</main>
@endsection