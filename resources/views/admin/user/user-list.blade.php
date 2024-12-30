@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('components.search-form', ['route' => route('admin.user.list')])
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">회원 목록</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                            <thead>
                                <tr class="border-2 border-bottom border-primary border-0"> 
                                    <th scope="col" class="ps-0 text-center">번호</th>
                                    <th scope="col" class="text-center">회원 이메일</th>
                                    <th scope="col" class="text-center">회원명</th>
                                    <th scope="col" class="text-center">연락처</th>
                                    <th scope="col" class="text-center">메타웨이브 UID</th>
                                    <th scope="col" class="text-center" >가입일자</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($list as $key => $value)
                                <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.user.view', ['id' => $value->id]) }}';">
                                    <th scope="row" class="ps-0 fw-medium text-center">{{ $list->firstItem() + $key }}</th>
                                    <td>{{ $value->email }}</td>
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center">{{ $value->meta_uid }}</td>
                                    
                                    <td class="text-center">{{ $value->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        {{ $list->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection