@extends('master')
@section('content')
    <h1>Bước 1</h1>
    <div class="container mt-5">
        <h2>Bắt đầu giao dịch thanh toán</h2>
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Số tiền</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="account" class="form-label">Tài khoản đích</label>
                <input type="text" class="form-control" id="account" name="account" required>
            </div>
            <button type="submit" class="btn btn-primary">Tiếp tục</button>
        </form>
    </div>
@endsection
