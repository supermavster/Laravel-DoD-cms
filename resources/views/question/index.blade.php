@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content Questions -->
        <h2>Create new Question</h2>
        <form action="{{ route('question') }}" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" name="question" id="question" class="form-control" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option>Activo</option>
                                    <option>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row d-block m-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="options" id="optionOne" value="Yes" checked>
                            <label class="form-check-label" for="optionOne">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="options" id="optionTwo" value="No">
                            <label class="form-check-label" for="optionTwo">
                                No
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="options" id="optionThree" value="N/A">
                            <label class="form-check-label" for="optionThree">
                                N/A
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <!--/ Content User -->
            <div class="col-md">
                <div class="d-flex justify-content-end">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <a href="{{ (Request::url()) }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-dark">Create</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection