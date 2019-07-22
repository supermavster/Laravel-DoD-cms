@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content Questions -->
        <h2>Create new Question</h2>
        <form method="POST" action="{{ url("advertiser/{$advertiser->id}") }}" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $advertiser->title) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="url">Url Redirect</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="urlText">http://</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" id="url" name="url" aria-describedby="urlText" value="{{ old('url', $advertiser->url) }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status">Advertiser Status</label>
                                <select class="form-control" id="status" name="status" value="{{ old('status', $advertiser->status) }}">
                                    <option>Publish</option>
                                    <option>No Publish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="images">Advertiser Image</label>
                            <div id="alerts" class="alert alert-warning text-center" role="alert">
                                The size of the image must be 680px x 120px
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', $advertiser->image) }}">>
                                    <label class="custom-file-label" for="image" aria-describedby="inputGroupFile">Choose file</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
    <br />
    <!--/ Content User -->
    <div class="col-md">
        <div class="d-flex justify-content-end">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <a href="{{ (Request::url()) }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-dark">Edit</span>
            </button>
        </div>
    </div>
    </form>
</div>
</div>

@push('custom-scripts')
<script type="text/javascript">
    $("#image").on('click', function() {
        $("#alerts").removeAttr("class").addClass("alert alert-success text-center");
    });
</script>
@endpush

@endsection