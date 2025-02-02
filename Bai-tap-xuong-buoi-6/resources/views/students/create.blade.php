@extends('master')
@section('title')
    Thêm mới
@endsection
@section('content')
    <div class="text-center">
        <h1>Thêm mới sinh viên</h1>
    </div>

    @if (session()->has('alert') && !session('alert'))
        <div class="alert alert-danger">
            <ul>
                <li> {{ session('error') }}</li>
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="name" id="inputName" placeholder="Tên"
                        value="{{ old('name') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input type="email" class="form-control" name="email" id="inputName" placeholder="Email"
                        value="{{ old('email') }}" />
                </div>
            </div>
            {{-- Lớp --}}
            <div class="mb-3 row">
                <label for="" class="form-label col-4 ">Classroom</label>
                <div class="col-8">
                    <select class="form-select form-select-lg" name="classroom_id" id="">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $clr)
                            <option value="{{ $clr->id }}"
                                 {{ old('classroom_id') == $clr->id ? 'selected' : '' }}>
                                {{ $clr->name }} -
                                GV:{{ $clr->teacher_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Hộ chiếu --}}
            <div class="mb-3 row">
                <label for="inputName" class="col-4 col-form-label">Passport</label>
                <div class="col-8">
                    <input type="number" class="form-control" name="passport_number" id="inputName"
                        placeholder="passport number" value="{{ old('passport_number') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="issued_date" class="form-label col-4">Ngày cấp</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="issued_date" name="issued_date"
                        value="{{ old('issued_date') }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="expiry_date" class="form-label col-4">Ngày hết hạn</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                        value="{{ old('expiry_date') }}">
                </div>
            </div>

            {{-- Môn học --}}
            <div class="mb-3 row">
                <label for="" class="form-label col-4 ">Subject</label>
                <div class="col-8">
                    <select multiple class="form-select form-select-lg" name="subjects[]" id="">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} - {{ $subject->credits }} tín
                            </option>
                        @endforeach


                    </select>
                </div>
            </div>



            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
