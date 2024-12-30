<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href=" {{ asset('images/icon/aethir.png') }}" size="32x32"> 
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

@if(Auth::check() && !Request::is('register*'))
    @include('layouts.header')
@endif

@yield('content')

@if(Auth::check() && !Request::is('register*'))
    @include('layouts.footer')
@endif


<div class="modal fade" id="alertModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">알림</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="modalMessage" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmBtn">확인</button>
            </div>
        </div>
    </div>
</div>

<!--div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">확인 요청</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="modalMessage" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmBtn">확인</button>
                <button type="button" class="btn btn-danger" id="confirmBtn">취소</button>
            </div>
        </div>
    </div>
</div-->

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
@stack('script')

</body>
</html>
