@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md">
            <div class="d-flex justify-content-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-plus-circle"></i> Create New
                </button>
            </div>
        </div>
        <br />
        <!-- Content User -->
        <div class="card">
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
                            <td>
                                <a class="btn btn-default btn-delete" data-toggle="modal" data-target="#my-modal" href="{{route('notification.active',$notification)}}"><i class="far fa-trash mx-1"></i> Delete</a>
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-modal" action="{{route('notification')}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-control" id="users" name="users">
                        <option>Select</option>
                        @foreach($users as $user)
                        <option>{{$user->name}}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Seend</button>
                </div>
            </form>
        </div>
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
                $myModal.find('#form-modal').attr('action', url);
                var $dsBody = $myModal.find('div.modal-body');
                $dsBody.html('<p>Are you sure you want to delete the question #' + id + '?</p>');
            });
        }
    });
</script>
@endpush

@endsection