@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5">
    @if($mode == 'write')
    <form method="POST" id="ajaxForm" action="{{ route('board.write') }}" >
    @else
    <form method="POST" id="ajaxForm" action="{{ route('board.modify') }}" >
    @endif
        @csrf
        <input type="hidden" name="code" value="{{ $board->board_code }}">
        @if($mode == 'modify')
        <input type="hidden" name="id" value="{{ $view->id }}">
        @endif
        <div class="mb-4">
            <h5 class="card-title">
                @if($mode == 'write')
                {{ $board->board_name }} 작성
                @else
                {{ $board->board_name }} 수정
                @endif
            </h5>    
        </div>
        <div class="mb-4">
            <label for="subject" class="form-label fw-bold">제목</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ $view->subject ?? '' }}" >
        </div>

        <div class="mb-4">
            <label for="content" class="form-label fw-bold">내용</label>
            <textarea class="form-control h-100" id="content" name="content" rows="20">{{ $view->content ?? '' }}</textarea>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <a href="{{ route('board.list', ['code' => $board->board_code ])}}" class="btn btn-secondary">목록</a>
                    @if($mode == 'write')
                    <button type="submit" class="btn btn-danger">등록</button>
                    @else
                    <button type="submit" class="btn btn-danger">수정</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</main>
@endsection

@push('script')
@endpush    