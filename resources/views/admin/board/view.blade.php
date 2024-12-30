@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">게시글 보기</h5>    
                </div>
                <hr>
                <table class="table table-bordered mt-5 mb-5">
                    <tbody>
                        <tr>
                            <th class="text-center align-middle">게시판</th>
                            <td class="align-middle">{{ $board->board_name }}</td>
                            <th class="text-center align-middle">아이디</th>
                            <td class="align-middle">{{ $user->account }}</td>
                            <th class="text-center align-middle">이름</th>
                            <td class="align-middle">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">제목</th>
                            <td colspan=5 class="align-middle">{{ $view->subject }}</td>
                        </tr>
                        <tr>
                            <td colspan=6 class="align-middle">{!! nl2br(e($view->content)) !!}</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                @if(isset($comment))
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <h5 class="card-title">답글</h5>    
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-5 mb-5">
                        {!! nl2br(e($comment->content)) !!}
                </div>
                <hr>
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('admin.board.list', ['code' => $board->board_code ]) }}" class="btn btn-secondary">목록</a>
                        @if(isset($comment))
                            <a href="{{ route('admin.board.view', ['code' => $board->board_code, 'mode' => 'comment', 'id' => $view->id ]) }}" class="btn btn-info ms-2">답글 수정</a>
                        @else
                            <a href="{{ route('admin.board.view', ['code' => $board->board_code, 'mode' => 'comment', 'id' => $view->id ]) }}" class="btn btn-info ms-2">답글 달기</a>
                        @endif
                    </div>
                    <a href="{{ route('admin.board.view', ['code' => $board->board_code, 'mode' => 'modify', 'id' => $view->id ]) }}" class="btn btn-danger">게시글 수정</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush