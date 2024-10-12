@extends('master')
@section('title')
    Chi tiết
@endsection
@section('content')
    <div class="text-center">
        <h1>Thông tin chi tiết sinh viên:{{ $student->name }}</h1>
    </div>

    <div class="container mt-4">
        <h2 class="mb-3">Thông tin sinh viên</h2>
        <div class="card mb-4">
            <div class="card-header">
                Thông tin cơ bản
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td>{{ $student->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tên</th>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{ $student->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h3 class="mb-3">Thông tin lớp học</h3>
        <div class="card mb-4">
            <div class="card-header">
                Lớp học
            </div>
            <div class="card-body">
                @if (isset($student->classroom))
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Tên lớp</th>
                                <td>{{ $student->classroom->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Giáo viên</th>
                                <td>{{ $student->classroom->teacher_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Sinh viên chưa có lớp học</p>
                @endif
            </div>
        </div>

        <h3 class="mb-3">Thông tin hộ chiếu</h3>
        <div class="card mb-4">
            <div class="card-header">
                Hộ chiếu
            </div>
            <div class="card-body">
                @if (isset($student->passport))
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Số hộ chiếu</th>
                                <td>{{ $student->passport->passport_number }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ngày cấp</th>
                                <td>{{ $student->passport->issued_date }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ngày hết hạn</th>
                                <td>{{ $student->passport->expiry_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Chưa có thông tin hộ chiếu</p>
                @endif
            </div>
        </div>

        <h3 class="mb-3">Môn học đã đăng ký</h3>
        <div class="card mb-4">
            <div class="card-header">
                Danh sách môn học
            </div>
            <div class="card-body">
                @if (isset($student->subjects) && count($student->subjects) > 0)
                    <ul class="list-group">
                        @foreach ($student->subjects as $subject)
                            <li class="list-group-item">
                                {{ $subject->name }} - {{ $subject->credits }} tín chỉ
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Chưa đăng ký môn học</p>
                @endif
            </div>
        </div>
    </div>

@endsection
