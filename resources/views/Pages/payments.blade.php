@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Content User -->
            <div class="card">
                <h5 class="card-header">Payments</h5>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr style="line-height: 1">
                            <th>NO.</th>
                            <th>Users</th>
                            <th>Demolition Type</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Dates</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td style="padding: 40px 0">
                                    <span class="text-center">
                                        {{$payment->id}}
                                    </span>
                                </td>
                                <td style="padding: 40px 0">
                                    <a href="{{ url('users/'.$payment->demolition->first()->user->first()->id)}}">
                                        {{$payment->demolition->first()->user->first()->name }}
                                    </a>
                                </td>
                                <td style="padding: 40px 0">
                                    <span class="text-center">
                                        {{$payment->demolition->first()->types->first()->name }}
                                    </span>
                                </td>
                                <td style="padding: 35px 0">
                                    <button type="button"
                                            class="btn btn-{{$payment->status=='completed'?'success':'danger'}}">{{ ucfirst($payment->status) }}</button>
                                </td>
                                <td style="padding: 40px 0">
                                    <span class="text-center">${{$payment->total}}</span>
                                </td>
                                <td>
                                    <span class="text-left" style="display: inline-grid">
                                        <span>Created at: {{$payment->created_at }}</span>
                                        <span>Started at: {{$payment->started_at }}</span>
                                        <span>End at: {{$payment->end_at }}</span>
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
