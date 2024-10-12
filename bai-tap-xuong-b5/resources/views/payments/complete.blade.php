@extends('master')

@section('content')
    <div class="container mt-5">
        @if ($transaction)
            <h2>Giao dịch hoàn tất</h2>
            <p><strong>Số tiền: </strong>  {{ $transaction->amount }}</p>
            <p><strong>Tài khoản đích:</strong> {{ $transaction->receiver_account }}</p>
            <p><strong>ID giao dịch:</strong> {{ $transaction->transaction_id }}</p>
            <p><strong>Trạng thái:</strong> {{ $transaction->status }}</p>
            <a href="{{ route('payments.start') }}" class="btn btn-primary">Thực hiện giao dịch mới</a>
        @else
            <p>Không tìm thấy giao dịch</p>
        @endif
    </div>
@endsection
