@extends('layouts.admin')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <style>
        button:focus,
        textarea:focus,
        input:focus {
            outline: 0 !important;
        }

    </style>
@stop

@section('content')
<div class="white-box">
    @if (Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li class="text-center">{{ Session::get('success') }}</li>
            </ul>
        </div>
    @endif
    
    <div class="col-mod-12">
        <div class="col-mod-3 col-lg-3">
            <h3 class="box-title text-success m-b-0">Expenses</h3>
            <p class="text-muted m-b-30">List of all Expenses</p>
        </div>        
        <div class="col-mod-8 col-lg-8">
            <form action="{{route('add-expenses')}}" method="post" enctype="multipart/form-data" id="ProjectsForm">
                {{ csrf_field() }}
                <input id="editId" name="editId" type="hidden" value='{{isset($expenseses->id)?$expenseses->id:" "}}'>
                <div class="form-group" style="margin-bottom:0px;">
                    <label for="exampleInputPrice">Amount</label>
                    <input type="text" class="form-control" id="amount" placeholder="" name="amount" value="{{isset($expenseses->amount)?$expenseses->amount:''}}">
                    <span class='error' id="amount_error" ></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPrice">Purpose</label>
                    <textarea type="text" class="form-control" id="purpose" rows="10" placeholder="" name="purpose" value="">{{isset($expenseses->purpose)?$expenseses->purpose:''}}</textarea>
                    <span class='error' id="purpose_error" ></span>
                </div>
                <div class="form-group">
                    <label for="featured_image">Image</label> <br>
                    <input type="file" id="file1" class="form-control required d-none image" name="image">
                    <span id="select_file" class="ml-3"> {{isset($expenseses->receipt)?$expenseses->receipt:''}}</span>
                    <small class="text-danger msgimage"></small>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="background:#7DCE4C;border:1px solid #7DCE4C">Submit</button>
                </div>
            </form>                
        </div>
        <div class="col-mod-1 col-lg-1"> </div>        
    </div> 
    <div class="clear"></div><hr/>
    <div class="table-responsive col-mod-12">
        <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
            <thead>
                <tr role="row">
                    <th > Date </th>
                    <th >Amount</th>
                    <th >Purpose</th>
                    <th >Receipt</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $k => $data)
                <tr role="row" class="odd">
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->amount }}</td>
                    <td>{{ $data->purpose }}</td>
                    <td>{{ $data->receipt }}</td>
                    <td role="row">
                        <button class="btn btn-primary"><a href="{{route('edit-expenses', ['id' => $data->id])}}" style="color:#fff">Edit</a></button>
                        <button class="btn btn-danger"><a href="{{route('expenses-delete', ['id' => $data->id])}}" style="color:#fff">Delete</a></button>
                    </td>
                </tr>
                @endforeach
            </tbody> 
        </table>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>

<script>
    //======== Raisul =======//
    //=====form validation=========//
    $('#ProjectsForm').submit((event)=>{
        const amount =  $('#amount').val();
        const purpose =  $('#purpose').val();
        if(amount == 0 ){
            $('#amount_error').html('Please Select amount');
            return false;
        }
        else if(purpose == ''){
            $('#purpose_error').html('Please Enter purpose');
            return false;
        }
        
        else{
            return true;
        }
    });

  
</script>
@stop