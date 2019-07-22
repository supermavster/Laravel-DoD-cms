@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- Content Questions -->
        <div class="col-md">
            <div class="d-flex justify-content-end">
                <a href="{{route('question')}}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Create New</a>
            </div>
        </div>
        <br />
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
                                <div style="display: grid">
                                    <a href="{{ route('question.edit', $question) }}">
                                        <i class="fas fa-edit mx-1"></i>
                                        View/Edit
                                    </a>
                                    <a class="btn btn-default btn-delete" data-toggle="modal" data-target="#my-modal" href="{{route('question.active',$question)}}"><i class="far fa-eye mx-1"></i> Active</a>

                                </div>
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
        var $myModal = jQuery('#my-modal');

        // Modal to delete record
        var $btDelete = jQuery('.btn-delete');
        if ($btDelete.length) {
            $btDelete.click(function(e) {
                e.preventDefault();

                var url = jQuery(this).attr('href');
                var id = url.replace(/[^0-9]/g, '');

                // Objects from alert modal
                var $dsBody = $myModal.find('div.modal-body');
                //var $btConfirm = jQuery('#bt-modal-confirm');
                var $btCancel = jQuery('#bt-modal-cancel');
                var $formBase = jQuery('#form-modal');
                $formBase.attr('action', url);
                $dsBody.html('<p>Are you sure you want to delete the question #' + id + '?</p>');

                //$btConfirm.attr('href', url).removeAttr('data-dismiss');
            });
        }
    });
</script>
@endpush

@endsection