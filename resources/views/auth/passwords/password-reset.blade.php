@extends('layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="mb-4">
                                <h3 class="text-center">비밀번호 재설정</h3>
                            </div>
                            <div class="mb-3">
                                <p>비밀번호를 재설정하려면 아래 링크를 클릭하세요:</p>
                                <a href="{{ $resetUrl }}">비밀번호 재설정</a>
                                <p>링크 유효 시간: 60분</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
</div>
   

@endsection