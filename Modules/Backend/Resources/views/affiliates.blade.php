@extends('backend::layouts.master')
@section('backend.content')

<div class="w3-container">
    <div class="w3-padding w3-margin-top">
        <button class="w3-black w3-round w3-card-4 w3-button w3-margin w3-right" onclick="onNew();">Add New Affiliate</button>
    </div>
    <div class="w3-padding w3-margin-bottom">
        <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
            <thead class="w3-teal">
                <th>#</th>
                <th>Logo</th>
                <th>Website</th>
                <th>Options</th>
            </thead>
            <tbody>
                @foreach($affiliates as $affiliate)
                <tr>
                    <td class="w3-center">{{$affiliate->id}}</td>
                    <td><img width="100px" height="30px;" src="{{asset('data/imgs/logos/'.$affiliate->logo)}}"></td>
                    <td>{{$affiliate->website}}</td>
                    <td>
                        <button class="btn btn-primary" onclick="onEdit({{$affiliate->id}})">Edit</button>
                        <button class="btn btn-danger" onClick="onRemove({{$affiliate->id}})">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form action="{{route('admin.affiliatesSave')}}" method="post" enctype="multipart/form-data" id="modal_form">
        <input type="hidden" name="aff_id" id="aff_id">
        <input type="hidden" name="mode" id="mode">
        {{ csrf_field() }}
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Affiliate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body w3-container w3-padding">

                        <div class="w3-row w3-padding w3-margin-top">
                            <label class="w3-text-grey">Name:</label>
                            <input type="input" class="w3-input w3-border" name="name" id="name" required>
                        </div>
                        <div class="w3-row w3-padding w3-margin-top">
                            <label class="w3-text-grey">Logo:</label>
                            <input type="file" class="w3-input w3-border" name="logo" id="logo" required>
                        </div>
                        <div class="w3-row w3-padding w3-margin-top">
                            <label class="w3-text-grey">Website:</label>    
                            <input type="text" class="w3-input w3-border" name="website" id="website" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save</button>
                </div>
            </div>
        </div>
    </form> 
    </div>
</div>

<script>
    function onNew() {
        $("#name").val('');
        $("#website").val('');
        $("#mode").val("save");
        $("#addNewModal").modal();
    }
    function onEdit(id) {
        let affiliates = {{$affiliates}};
        $("#name").val(affiliates[id].name);
        $("#website").val(affiliates[id].website);
        $("#aff_id").val(affiliates[id].id);
        $("#mode").val("update");
        $("#addNewModal").modal();
    }
    function onRemove(id) {
        if(confirm("Are you sure?")) {
            location.href = "affiliates/remove/"+id;
        }
        
    }
</script>
@stop

