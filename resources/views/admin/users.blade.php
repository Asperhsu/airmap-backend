@extends('layouts.admin')

@section('content')
<div class="container">
    @include('partials.alerts')

    <div class="row justify-content-center mt-3">
        <a href="{{ route('admin.register') }}" class="btn btn-primary btn-sm mr-1">
            <span class="fa fa-plus"></span> 新增使用者
        </a>
        <a href="{{ route('admin.chgpassword', [$userId]) }}" class="btn btn-warning btn-sm">
            <span class="fas fa-user-edit"></span> 更改我的密碼
        </a>
    </div>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.chgpassword', [$user->id]) }}" class="btn btn-warning btn-sm">
                        <span class="fa fa-edit"></span> 更改密碼
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
