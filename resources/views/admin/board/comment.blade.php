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
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">답글 작성</h5>    
                </div>
                <hr>
                <form method="post" id="ajaxForm" action="{{ route('admin.board.comment') }}">
                    @csrf
                    <input type="hidden" name="code" value="{{ $board->board_code }}" >
                    <input type="hidden" name="id" value="{{ $view->id }}" >
                    <input type="hidden" name="subject" value="Re:{{ $view->subject }}" >
                    <table class="table table-bordered mt-5 mb-5">
                        <tbody>
                            <tr>
                                <th class="text-center align-middle">내용</th>
                                <td colspan=3 class="align-middle">
                                    @if(isset($comment))
                                    <textarea name="content" class="form-control" id="content" rows="8" >{!! nl2br(e($comment->content)) !!}</textarea>
                                    @else
                                    <textarea name="content" class="form-control" id="content" rows="8" ></textarea>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.board.list', ['code' => $board->board_code ]) }}" class="btn btn-secondary">목록</a>
                        @if(isset($comment))
                        <button type="submit" class="btn btn-danger">답글 수정</button>
                        @else
                        <button type="submit" class="btn btn-danger">답글 작성</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush