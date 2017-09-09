@extends('layouts.admin')

@section('title', 'Account Management')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Admins
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-default">
                                <tr>
                                    <td>No</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $count => $admin)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td>{{ $admin['email'] }}</td>
                                    <td>{{ $admin['firstname'] }} {{ $admin['lastname'] }}</td>
                                    <td>
                                        <button
                                                class="btn btn-danger"
                                                data-id="{{ $admin['id'] }}"
                                                onclick="deleteAdmin(this)"
                                                style="cursor: pointer"
                                        >Delete User</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        User Accounts
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-default">
                                <tr>
                                    <td>No</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Suspended</td>
                                    <td>Activated</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $count => $account)
                                    <tr>
                                        <td>{{ $count+1 }}</td>
                                        <td>{{ $account['email'] }}</td>
                                        <td>{{ $account['firstname'] }} {{ $account['lastname'] }}</td>
                                        <td>
                                            @if($account['user_info']['suspended'] == null || $account['user_info']['suspended'] == 0)
                                                <div class="btn btn-primary">Not Suspended</div>
                                            @else
                                                <div class="btn btn-danger">Suspended</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($account['activation_code'] == null)
                                                <div class="btn btn-primary">Activated</div>
                                            @else
                                                <div class="btn btn-danger">Not Activated</div>
                                            @endif
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary m-1"
                                                id="{{ $account['id'] }}"
                                                onclick="userInfo(this)"
                                                style="cursor: pointer"
                                            >User Information</button>
                                            <form action="{{ URL::to('admin/user_transactions') }}" method="POST">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="id" value="{{ $account['id'] }}">

                                                <button class="btn btn-primary m-1" style="cursor: pointer">User Transactions</button>
                                            </form>
                                            <button
                                                class="btn btn-warning m-1"
                                                id="{{ $account['id'] }}"
                                                onclick="suspendUser(this)"
                                                style="cursor: pointer"
                                            >(un)Suspend User</button>
                                            <button
                                                class="btn btn-danger m-1"
                                                id="{{ $account['id'] }}"
                                                onclick="deleteUser(this)"
                                                style="cursor: pointer"
                                            >Delete User</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection