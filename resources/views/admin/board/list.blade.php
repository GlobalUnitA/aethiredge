@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <h5 class="card-title">{{ $board->board_name }}</h5>
                            <a href="{{ route('admin.board.view', ['code' => $board->board_code, 'mode' => 'write' ]) }}" class="btn btn-primary">작성</a>
                        </div>
                        <form method="post" id="ajaxForm" action="{{ route('admin.board.delete') }}">
                            @csrf
                            <input type="hidden" name="code" value="{{ $board->board_code }}">
                            <div class="table-responsive">
                                <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                                    <thead>
                                        <tr class="border-2 border-bottom border-primary border-0"> 
                                            <th scope="col" class="ps-0 text-center"></th>
                                            <th scope="col" class="text-center">번호</th>
                                            <th scope="col" class="text-center">제목</th>
                                            <th scope="col" class="text-center">작성자</th>
                                            <th scope="col" class="text-center">작성일자</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @if($list->isNotEmpty())
                                        @foreach ($list as $key => $value)
                                        <tr>
                                            <td scope="row" class="ps-0 fw-medium text-center"><input type="checkbox" name="check[]" value="{{ $value->id }}" class="form-check-input" /></td>
                                            <td class="text-center">{{ $list->firstItem() + $key }}</td>
                                            <td class="text-center"><a class="text-black" href="{{ route('admin.board.view', ['code' => $board->board_code, 'mode' => 'view', 'id' => $value->id]) }}">{{ $value->subject }}</a></td>
                                            <td class="text-center">{{ $value->account }}</td>
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
                            <div class="d-flex justify-content-end mt-5">        
                                <button type="submit" id="postDeletebtn" class="btn btn-danger">게시글 삭제</button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $list->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection