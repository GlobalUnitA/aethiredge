@extends('layouts.master')

@section('content')
<main class="container-fluid py-5">
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-2 text-muted">{{ Auth::user()->name }}({{ Auth::user()->id }}) 회원님</div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="text-primary mb-0">{{ config('app.name', 'Laravel') }} 보유량</h5>
                    <h4 class="fw-bold mt-1">{{ $amount }} EA</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <a href="{{ route('device') }}">
                <div class="p-3 rounded bg-light text-black fw-bold fs-4">
                    구매하기({{ config('app.name', 'Laravel') }})
                </div>
            </a>
        </div>
        <div class="col-12">
            <a href="{{ route('staking') }}">
                <div class="p-3 rounded text-black fw-bold fs-4" style="background-color: #e8f5e9;">
                    스테이킹 하기({{ config('app.name', 'Laravel') }})
                </div>
            </a>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="mb-3">보너스 확인</h6>
        <div class="row g-3">
            <div class="col-6">
                <a href="{{ route('bonus.device') }}" class="btn btn-outline-primary w-100">USDT보너스</a>
            </div>
            <div class="col-6">
                <a href="{{ route('staking.test') }}" class="btn btn-outline-primary w-100">스테이킹</a>
            </div>
        </div>
    </div>
</main>
@endsection
