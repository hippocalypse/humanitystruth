@extends('backend.layouts.app')
@section('content')

    <div id="page-wrapper">
        <div class="row  w3-margin-top">
            <div class="col-lg-12">
                <h1 class="page-header">Affiliates</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="row w3-padding w3-margin-top">
                <button class="btn btn-primary" onclick="onNew();">Add New Affiliate</button>
            </div>
            <div class="row w3-padding">
                <table class="w3-table 3-bordered w3-striped w3-border w3-hoverable">
                    <thead class="w3-green">
                        <th>No</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Website</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($affiliates as $affiliate) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$affiliate->name?></td>
                            <td><img width="100px" height="30px;" src="{{asset('uploads/'.$affiliate->logo)}}"></td>
                            <td><?=$affiliate->website?></td>
                            <td>
                                <button class="btn btn-primary" onclick="onEdit(<?=$i-1?>)">Edit</button>
                                <button class="btn btn-danger" onClick="onRemove(<?=$affiliate->id?>)">Remove</button>
                            </td>
                        </tr>
                        <?php $i++; } ?>
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
                                <input type="file" class="w3-input w3-border" name="logo" id="logo">
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

    </div>
    <!-- /#page-wrapper -->
<script>
    function onNew() {
        $("#name").val('');
        $("#website").val('');
        $("#mode").val("save");
        $("#addNewModal").modal();
    }
    function onEdit(id) {
        var affiliates = <?=$affiliates?>;
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
@endsection

