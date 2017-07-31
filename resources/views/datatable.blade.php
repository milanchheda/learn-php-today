@extends('layouts.app')

@section('content')
<div class="container container-fluid" id="manageContainer">
    {{ csrf_field() }}
    <div class="table-responsive">
        <table class="datatable" id="datatable">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">View Count</th>
                    <th class="text-center">Upvote Count</th>
                    <th class="text-center">Recomment Count</th>
                    <th class="text-center">Published On</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
            <tr class="item{{$item->id}}">
                <td>{{$item->id}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->link}}</td>
                <td>{{$item->view_count}}</td>
                <td>{{$item->upvote_count}}</td>
                <td>{{$item->recommend_count}}</td>
                <td>{{$item->published_on}}</td>
                <td>
                <!-- <button class="edit-modal btn btn-info"
                        data-info="{{$item->id}},{{$item->first_name}},{{$item->last_name}},{{$item->email}},{{$item->gender}},{{$item->country}},{{$item->salary}}">
                        <span class="glyphicon glyphicon-edit"></span> Edit
                    </button> -->
                    <button class="delete-modal btn btn-danger"
                        data-info="{{$item->id}},{{$item->first_name}},{{$item->last_name}},{{$item->email}},{{$item->gender}},{{$item->country}},{{$item->salary}}">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {{ $data->links() }} </div>
    </div>
</div>
<div id="myManageLinkModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="deleteContent">
                    Are you Sure you want to delete <span class="dname"></span> ? <span
                        class="hidden did"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class='glyphicon'> </span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
