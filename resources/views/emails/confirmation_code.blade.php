@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content User -->
        <div class="card">
            <h5 class="card-header">Verify Your Email Address</h5>
            <div class="card-body">

                Thanks for creating an account with the verification demo app.
                Please follow the link below to verify your email address
                <a class="btn btn-success" href="{{ URL::to('verify/' . $confirmation_code) }}">
                    Verify Here
                </a>.
            </div>
        </div>
        <!--/ Content User -->
    </div>
</div>

@endsection