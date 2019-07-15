@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-4">
                <!-- Count Users -->
                <button class="btn btn-primary boxmain">
                    <span class="badge badge-light box">{{count($users)}}</span> Users
                </button>
                <!--/ Count Users -->
            </div>
            <div class="col-4">
                <!-- Count Demolitions -->
                <button class="btn btn-primary boxmain">
                    <span class="badge badge-light box">{{count($users)}}</span> Demolitions
                </button>
                <!--/ Count Demolitions -->
            </div>
            <div class="col-4">
                <!-- Count Payments -->
                <button class="btn btn-primary boxmain">
                    <span class="badge badge-light box">{{count($users)}}</span> Payments
                </button>
                <!--/ Count Payments -->
            </div>
        </div>

        <div class="row">
            <div class="col col-md-6">
                <!-- Content User -->
                <div class="card">
                    <h5 class="card-header">Last Registered users</h5>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('users')}}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-{{$user->status?'success':'danger'}}">{{ $user->status?'Active':'Inactive' }}</button>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Content User -->
            </div>

            <div class="col col-md-6">
                <!-- Content User -->
                <div class="card">
                    <h5 class="card-header">Last demolition requests</h5>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('users')}}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-{{$user->status?'success':'danger'}}">{{ $user->status?'Active':'Inactive' }}</button>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Content User -->
            </div>
        </div>


    </div>
@endsection
