@extends('master')
@section('title')
    Quản lý
@endsection
@section('content')
    <div class="text-center">
        <h1>Quản lý sinh viên</h1>
    </div>
    @if (session()->has('alert') && session('alert'))
        <div class="alert alert-success">
            <ul>
                <li>Thao tác thành công</li>
            </ul>
        </div>
    @endif

    <a name="" id="" class="btn btn-primary my-2" href="{{ route('students.create') }}">Thêm
        mới</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-bordered align-middle">
            <thead class="table-light">
                <caption>
                    Student
                </caption>
                <tr>
                    <th>ID </th>
                    <th>Name </th>
                    <th>Email </th>
                    <th>Lớp học </th>
                    <th>Created at </th>
                    <th>Updated at </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $std)
                    <tr class="table-">
                        <td scope="row">{{ $std->id }}</td>
                        <td>{{ $std->name }}</td>
                        <td>{{ $std->email }}</td>
                        <td>{{ $std->classroom->name }}</td>
                        <td>{{ $std->created_at }}</td>
                        <td>{{ $std->updated_at }}</td>
                        <td class="text-center ">
                            <a name="" id="" class="btn btn-info my-2 btn-sm"
                                href="{{ route('students.show', $std) }}" role="button">Xem</a>
                            <a name="" id="" class="btn btn-warning btn-sm"
                                href="{{ route('students.edit', $std) }}" role="button">Sửa</a>

                            <form action="{{ route('students.destroy', $std) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Xác nhận xóa ?')" type="submit" class="btn btn-danger ">
                                    Xóa mềm
                                </button>
                            </form>

                            <form action="{{ route('students.forceDestroy', $std) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Xác nhận xóa ?')" type="submit"
                                    class="btn btn-dark  my-2">
                                    Xóa Cứng
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>

            </tfoot>
        </table>
        {{ $data->links() }}
    </div>
@endsection
