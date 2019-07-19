@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Content Questions -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-header">Advertisers</h5>
                    <table class="table text-center">
                        <tbody>
                        @foreach($advertisers as $advertiser)
                            <tr>
                                <td class="text-left">
                                    <img src="{{asset($advertiser->image?$advertiser->image:'media/no-img.jpg')}}">
                                </td>
                                <td style="display:inline-grid;padding: 20px 0">
                                    <span>Title: {{$advertiser->title}}</span>
                                    <span><a href="{{$advertiser->url}}">{{$advertiser->url}}</a> </span>
                                </td>
                                <td style="padding: 35px 0">
                                    <button class="btn btn-{{$advertiser->status=='active'?'success':'danger'}}">{{ $advertiser->status=='active'?'Active':'Inactive' }}</button>
                                </td>
                                <td style="display:inline-grid;padding: 20px 0">
                                    <span>Created at: {{$advertiser->created_at}}</span>
                                    <span>Created by: {{($advertiser->user->name)}}</span>
                                </td>
                                <td style="padding: 20px 0">
                                    <form action="" method="post">
                                        <div style="display: grid">
                                            <a href="">
                                                <i class="fas fa-edit mx-1"></i>
                                                View/Edit
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
