@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content Questions -->
        <div class="col-md">
            <div class="d-flex justify-content-end">
                <a href="{{route('advertiser')}}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Create New</a>
            </div>
        </div>
        <br />
        <div class="card">
            <div class="card-body">
                <h5 class="card-header">Advertisers</h5>
                <table class="table text-center">
                    <tbody>
                        @foreach($advertisers as $advertiser)
                        <tr>
                            <td class="text-left">
                                <img src="{{asset($advertiser->image?$advertiser->image:'media/no-img.jpg')}}" width="100" height="70">
                            </td>
                            <td style="display:inline-grid;padding: 20px 0">
                                <span>Title: {{$advertiser->title}}</span>
                                <span><a href="{{$advertiser->url}}">{{$advertiser->url}}</a> </span>
                            </td>
                            <td style="padding: 35px 0">
                                <button class="btn btn-{{$advertiser->status=='Publish'?'success':'danger'}}">{{ $advertiser->status }}</button>
                            </td>
                            <td style="display:inline-grid;padding: 20px 0">
                                <span>Created at: {{$advertiser->created_at}}</span>
                                <span>Created by: {{($advertiser->user->name)}}</span>
                            </td>
                            <td style="padding: 20px 0">
                                <form action="" method="post">
                                    <div style="display: grid">
                                        <a href="{{ route('advertiser.edit', $advertiser) }}">
                                            <i class="fas fa-edit mx-1"></i>
                                            View/Edit
                                        </a>
                                        <a class="btn btn-default btn-delete" data-toggle="modal" data-target="#my-modal" href="{{route('advertiser.active',$advertiser)}}"><i class="far fa-trash mx-1"></i> Delete</a>
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


@push('custom-scripts')
<!-- modal -->
<!-- Button trigger modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-modal" action="" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-header">
                    <h3>Delete Question</h3>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <a id="bt-modal-cancel" href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                    <button type="submit" id="bt-modal-confirm" class="btn btn-danger btn-ok">Delete</button>

                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(window).on("load", function() {
        var $myModal = $('#my-modal');
        // Modal to delete record
        var $btDelete = $('.btn-delete');
        if ($btDelete.length) {
            $btDelete.click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var id = url.replace(/[^0-9]/g, '');
                // Objects from alert modal
                $('#form-modal').attr('action', url);
                var $dsBody = $myModal.find('div.modal-body');
                $dsBody.html('<p>Are you sure you want to delete the question #' + id + '?</p>');
            });
        }
    });
</script>
@endpush


@endsection