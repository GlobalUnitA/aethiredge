@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        @if($mode == 'write')
                        게시글 작성
                        @else
                        게시글 수정
                        @endif
                    </h5>    
                </div>
                @if($mode == 'write')
                <form method="POST" id="ajaxForm" action="{{ route('admin.board.write') }}" >
                @else
                <form method="POST" id="ajaxForm" action="{{ route('admin.board.modify') }}" >
                @endif
                    @csrf
                    <input type="hidden" name="code" value="{{ $board->board_code }}">
                    @if($mode == 'modify')
                    <input type="hidden" name="id" value="{{ $view->id }}">
                    @endif
                    <hr>
                    <table class="table table-bordered mt-5 mb-5">
                        <tbody>
                            @if($mode == 'modify')
                            <!--tr>
                                <th class="text-center align-middle">아이디</th>
                                <td class="align-middle"></td>
                                <th class="text-center align-middle">이름</th>
                                <td class="align-middle"></td>
                            </tr-->
                            @endif
                            <tr>
                                <th class="text-center align-middle">제목</th>
                                <td colspan=3 class="align-middle">
                                    <input type="text" name="subject" value="{{ $view->subject ?? '' }}" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">내용</th>
                                <td colspan=3 class="align-middle">
                                    <textarea name="content" class="form-control" id="content" rows="12" >{{ $view->content ?? '' }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.board.list', ['code' => $board->board_code ]) }}" class="btn btn-secondary">목록</a>
                        @if($mode == 'modify')
                        <button type="submit" class="btn btn-danger">수정</button>
                        @else
                        <button type="submit" class="btn btn-danger">작성</button>
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