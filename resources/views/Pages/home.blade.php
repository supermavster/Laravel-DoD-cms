@extends('layouts.app')

@section('content')
<div class="row text-center">
    <div class="col-md-4 col-sm-4 col-xs-4">
        <!-- Count Users -->
        <div class="btn btn-primary boxmain">
            <div class="row">
                <div class="col-6">
                    <span class="badge badge-light box">{{count($users)>0?count($users):0}}</span>
                </div>
                <div class="col-6">
                    Users
                    <br />
                    <a href="{{route('users')}}">
                        View
                    </a>
                </div>
            </div>
        </div>
        <!--/ Count Users -->
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
        <!-- Count Users -->
        <div class="btn btn-primary boxmain">
            <div class="row">
                <div class="col-6">
                    <span class="badge badge-light box">{{count($demolitions)>0?count($demolitions):0}}</span>
                </div>
                <div class="col-6">
                    Demolitions
                    <br />
                    <a href="{{route('demolitions')}}">
                        View
                    </a>
                </div>
            </div>
        </div>
        <!--/ Count Users -->
    </div>

    <div class="col-md-4 col-sm-4 col-xs-4">
        <!-- Count Users -->
        <div class="btn btn-primary boxmain">
            <div class="row">
                <div class="col-6">
                    <span class="badge badge-light box">{{count($payments)>0?count($payments):0}}</span>
                </div>
                <div class="col-6">
                    Payments
                    <br />
                    <a href="{{route('payments')}}">
                        View
                    </a>
                </div>
            </div>
        </div>
        <!--/ Count Users -->
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
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
                        @foreach($users->take(7) as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users')}}">
                                    <img src="{{asset('media/no-img.jpg')}}" alt="{{ $user->name }}" width="50" height="50" class="rounded-circle">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-{{$user->status=='active'?'success':'danger'}}">{{ $user->status=='active'?'Active':'Inactive' }}</button>
                            </td>
                            <td>
                                <span style="line-height: 2.3;">{{ $user->created_at->format('Y-m-d')}}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Content User -->
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6">
        <!-- Content User -->
        <div class="card">
            <h5 class="card-header">Last demolition requests</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Demolition Type</th>
                            <th>User</th>
                            <th>Request Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demolitions->take(7) as $demolition)
                        <tr>
                            <td>
                                <a href="{{ route('demolitions.edit',$demolition)}}" style="line-height: 2.3;">
                                    {{ isset($demolition->types->first()->name)?$demolition->types->first()->name:'Non Name' }}
                                </a>
                            </td>
                            <td>
                                <span style="line-height: 2.3;">{{ $demolition->user->first()->name}}</span>
                            </td>
                            <td>
                                <span style="line-height: 2.3;">{{ $demolition->created_at->format('M d, Y')}}</span>
                            </td>
                            <td>
                                <button class="btn btn-{{preg_replace('/\s+/', '-', strtolower($demolition->status->name))}}">
                                    {{ $demolition->status->name }}
                                </button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Content User -->
    </div>
</div>
@endsection