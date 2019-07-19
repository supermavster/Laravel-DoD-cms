@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Content User -->
            <div class="card">
                <h5 class="card-header">Last Registered users</h5>
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr style="line-height: 1">
                            <th>NO.</th>
                            <th>Date of Notifications</th>
                            <th>Description of Notifications</th>
                            <th>Username</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <td>
                                    <span>
                                        {{$notification->id}}
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        {{$notification->created_at->format('d/m/Y')}}
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        {{$notification->description}}
                                    </span>
                                </td>
                                <td>
                                    <span>
                                        {{$notification->user->name}}
                                    </span>
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
