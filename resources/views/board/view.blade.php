@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">{{ $view->subject }}</h4>
        @if($board->board_code == 'notice')
        <span class="badge bg-primary">공지사항</span>
        @endif
    </div>
    <div class="post-info mb-2">
        <span class="me-3"><i class="bi bi-clock"></i> 작성일:{{ $view->created_at->format('Y-m-d') }}</span>
    </div>
    <div class="post-content p-4 mb-3">
    {!! nl2br(e($view->content)) !!}
    </div>

    @if(isset($comment))
    <div class="mt-3 mb-3">
        <h5 class="mb-0">답글완료</h5>
        <div class="post-content p-4 mb-3">
            {!! nl2br(e($comment->content)) !!}
        </div>
    </div>
    @endif
    
    <div class="d-flex justify-content-start align-items-center">
        <div>
            <a href="{{ route('board.list', ['code' => $board->board_code ])}}" class="btn btn-secondary">목록</a>
        </div>
    </div>
</main>
@endsection

@push('script')
@endpush