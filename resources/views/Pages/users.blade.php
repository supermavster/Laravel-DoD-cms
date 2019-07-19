@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Content User -->
            <div class="card">
                <h5 class="card-header">Last Registered users</h5>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr style="line-height: 1">
                            <th>User</th>
                            <th>Demolitions<br/>Request</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('users')}}">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{asset('media/no-img.jpg')}}"
                                                     alt="{{ $user->name }}" width="50"
                                                     height="50" class="rounded-circle">
                                            </div>
                                            <div class="col-8">
                                                <span>
                                                    Id: {{ $user->id }}<br/>
                                                    {{ $user->name }}<br/>
                                                    {{ $user->email }}<br/>
                                                    Register: {{ $user->created_at->format('Y-m-d') }}
                                                </span>
                                            </div>
                                        </div>


                                    </a>
                                </td>
                                <td style="padding: 35px 0">
                                    <button type="button"
                                            class="btn btn-default">View
                                    </button>
                                </td>
                                <td style="padding: 30px 0">
                                    <span class="text-center">Last login:<br/>{{ $user->created_at->format('Y-m-d')}}</span>
                                </td>
                                <td style="padding: 35px 0">
                                    <button class="btn btn-{{$user->status=='active'?'success':'danger'}}">{{ $user->status=='active'?'Active':'Inactive' }}</button>
                                </td>
                                <td style="padding: 20px 0">
                                    <form action="" method="post">
                                        <div style="display: grid">
                                            <a href="">
                                                <i class="fas fa-edit mx-1"></i>
                                                View/Edit
                                            </a>
                                            <a href="">
                                                <i class="far fa-comment-dots mx-1"></i>
                                                Notification
                                            </a>
                                            <submit><i class="far fa-eye mx-1"></i>Active</submit>
                                        </div>
                                    </form>
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
