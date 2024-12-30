<footer class="fixed-bottom bg-white border-top">
    @isset($notice)
    <a href="{{ route('board.view', ['code' => 'notice', 'mode' => 'view', 'id' => $notice->id]) }}" >
        <div class="alert alert-primary" role="alert">    
            <h6 class="alert-heading mb-1">공지</h6> 
            <p class="mb-0 small">{{ $notice->subject }}</p>
        </div>
    </a>
    @endif
    <div class="container-fluid">
        <div class="row text-center gy-2 py-2">
            <div class="col">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                    <i class="ti ti-home"></i>
                    <div class="small">Home</div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('register',['mid' => Auth::user()->id]) }}" class="text-decoration-none text-dark">
                    <i class="ti ti-user"></i>
                    <div class="small">회원가입</div>
                </a>
            </div>
            <div class="col">
                <a href="#" onclick="showModal('error', '준비중입니다.')" class="text-decoration-none text-dark">
                    <i class="ti ti-paperclip"></i>
                    <div class="small">추천링크</div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('device') }}" class="text-decoration-none text-dark">
                    <i class="ti ti-credit-card"></i>
                    <div class="small">구매하기</div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('board.list', ['code' => 'terms']) }}" class="text-decoration-none text-dark">
                    <i class="ti ti-file-description"></i>
                    <div class="small">이용약관</div>
                </a>
            </div>
        </div>
    </div>
</footer>