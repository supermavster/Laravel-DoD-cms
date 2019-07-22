@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content User -->
        <div class="card">
            <h5 class="card-header">Demolitions</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr style="line-height: 1">
                            <th>Demolition</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demolitions as $demolition)
                        <tr>
                            <td>
                                <span class="text-left" style="display: inline-grid">
                                    <span>Code: {{str_pad($demolition->id, 3, '0', STR_PAD_LEFT)}}</span>
                                    <span>Demolition Type: {{ isset($demolition->types->first()->name)?$demolition->types->first()->name:'Non Name' }}</span>
                                    <span>User: {{$demolition->user->first()->name}}</span>
                                    <span>Address: {{$demolition->address}}</span>
                                </span>
                            </td>
                            <td style="padding: 40px 0">
                                <span>{{$demolition->created_at->format('M d, Y')}}</span>
                            </td>
                            <td style="padding: 35px 0">
                                <button class="btn btn-{{preg_replace('/\s+/', '-', strtolower($demolition->status->name))}}">
                                    {{ $demolition->status->name }}
                                </button>


                            </td>
                            <td style="padding: 20px 0">
                                <form action="{{ route('demolitions.active', $demolition) }}" method="POST" style="display:inline-grid;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('demolitions.edit', $demolition) }}" class="btn btn-link"><span class="fa fa-edit"></span> View/Edit</a>
                                    <button type="submit" class="btn btn-link"><span class="fa fa-eye"> Active</span>
                                    </button>
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