@extends('master')

@section('content')
    <div class="container mt-5">
        <h2>Xác nhận thông tin giao dịch</h2>

        <p><strong>Số tiền:</strong> {{ $transaction['amount'] }}</p>
        <p><strong>Tài khoản đích:</strong> {{ $transaction['receiver_account'] }}</p>

        <!-- Thêm form nhập mã OTP -->
        <form action="{{ route('payments.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label">Nhập mã OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" placeholder="Nhập mã OTP" required>
            </div>

            <button type="submit" class="btn btn-success">Xác nhận giao dịch</button>
        </form>

        <form action="{{ route('payments.cancel') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Hủy giao dịch</button>
        </form>
    </div>
@endsection
