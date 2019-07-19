@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- Content Questions -->
            <div class="card">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr style="line-height: 1">
                            <th>Questions</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td class="text-left">
                                    <span>
                                        {{$question->id}}) {{$question->question}}
                                    </span>
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
