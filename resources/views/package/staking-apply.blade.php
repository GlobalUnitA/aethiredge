@extends('layouts.master')

@section('content')
<main class="container-fluid pt-5 mt-3 pb-5 mb-5">
    <div class="py-3">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body text-center py-4">
                <small class="text-muted d-block mb-1">총 입금수량</small>
                <h4 class="fw-bold mb-0">{{ number_format($apply['ath']) }} ATH</h4>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" id="ajaxForm" action = "{{ route('staking.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ea" value="{{ $apply['ea'] }}">
                    <input type="hidden" name="bundle" value="{{ $apply['bundle'] }}">
                    <input type="hidden" name="ath" value="{{ $apply['ath'] }}">
                    <h5 class="fw-bold mb-4">이미지 업로드</h5>

                    <div id="uploadBox" class="position-relative bg-light rounded p-4 text-center mb-4">
                        <input type="file" name="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" accept="image/jpeg,image/jpg,image/png" id="fileInput" style="cursor: pointer;">
                        <div id="defaultContent">
                            <h6 class="fw-bold mb-3">업로드</h6>
                            <p class="text-muted small mb-3">
                                ATH 이체 성공 후, 해당 화면을 캡쳐하여 업로드하세요.
                            </p>
                            <ul class="text-muted small text-start mb-0">
                                <li>파일 형식은 jpg, jpeg, png만 가능합니다.</li>
                                <li>최대 5MB까지만 업로드 가능합니다.</li>
                            </ul>
                        </div>

                        <img id="imagePreview" class="d-none w-100 rounded" style="object-fit: contain; max-height: 200px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">회사 ATH 주소</label>
                        <div class="input-group">
                            <input type="text" id="textToCopy" class="form-control" value="{{ $address }}" readonly>
                            <button type="button" id="copyBtn" class="btn btn-primary" >복사</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small">TXID</label>
                        <input type="text" name="txid" class="form-control" placeholder="TXID를 입력하세요">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 mb-4">신청하기</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script src="{{ asset('js/package/staking.js') }}"></script>
@endpush