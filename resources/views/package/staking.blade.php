@extends('layouts.master')

@section('content')
<main class="container-fluid pt-5 mt-3 pb-5 mb-5">
    <div class="px-3 mb-5">
        <form method="POST" action="{{ route('staking.apply') }}">
            @csrf
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="mt-4 mb-4">
                    <a href="{{ route('staking.test') }}">
                        <h5>스테이킹 내역</h5>
                    </a>
                </div>
                <div class="text-danger fs-3">
                    @if($waiting > 0)
                        심사대기 {{ $waiting }}건
                    @endif
                </div>
            </div>
            <div class="text-center mb-4">
                <img src="{{ asset('images/img_aethir_edge.png') }}" alt="Aethir Edge Device" class="img-fluid" style="max-width: 200px;">
                <h2 class="mt-3">Aethir Edge</h2>
            </div>
            <div class="mb-4">
                <label class="form-label">스테이킹 수량을 선택하세요</label>
                <input type="text" name="ea" id="ea" value="0" class="form-control mb-3" readonly data-bs-toggle="modal" data-bs-target="#quantityModal">
            </div>
            <div class="mb-4">
                <label class="form-label">ATH 수량</label>
                <input type="text" id="totalAth" class="form-control" value="0" disabled>
                <input type="hidden" name="ath">
                <input type="hidden" name="bundle">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 mb-4">구매하기</button>
        </form>
    </div>

    <div class="modal fade" id="quantityModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 mt-2">
                    <h5 class="modal-title">스테이킹 수량을 선택해주세요</h5>
                </div>
                <div class="modal-body pt-2">
                    <div class="list-group list-group-flush mt-3">
                        <span class="d-flex justify-content-between align-items-center w-100">
                                <span class="ms-5">ATH 수량</span>
                                <span>패키지 수량</span>
                        </span>
                        @foreach ($staking as $data)
                        <label class="list-group-item border-0 py-3 d-flex">
                            <input type="radio" name="quantity" id="{{ $data['ea'] }}" class="form-check-input me-3" value="{{ $data['ath'] }}">
                            <span class="d-flex justify-content-between align-items-center w-100">
                                <span>{{ number_format($data['ath']) }} ATH</span>
                                <span>{{ number_format($data['ea']) }} EA</span>
                            </span>
                        </label>    
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="ms-5">패키지 수량</span>
                        <div class="d-flex">
                            <button id="decreaseBtn" class="btn btn-outline-gary">-</button>
                            <input type="number" id="bundle" class="form-control mx-2" value="1" style="width: 60px; text-align: center;">
                            <button id="increaseBtn" class="btn btn-outline-gray">+</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <div class="row w-100 g-2">
                        <div class="col">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">취소</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary w-100" id="confirmQuantity">확인</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script src="{{ asset('js/package/staking.js') }}"></script>
@endpush    