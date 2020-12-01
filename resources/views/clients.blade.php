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
    @elseif(Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li class="text-center">{{ Session::get('error') }}</li>
            </ul>
        </div>
    @else
        <div class=""></div>
    @endif
    
    <div class="col-mod-12">
        <div class="col-mod-3 col-lg-3">
            <h3 class="box-title text-success m-b-0">Clients</h3>
            <p class="text-muted m-b-30">List of all Clients</p>
        </div>        
        <div class="col-mod-4 col-lg-4">
            <form action="{{route('add-clients')}}" method="post" enctype="multipart/form-data" id="clientsForm">
                {{ csrf_field() }}
                <div class="form-group" style="margin-bottom:0px;">
                    <label for="exampleInputPrice">Name</label>
                    <input type="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="" name="name" value="">
                    <span class="error" id="errorname" ></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPrice">Japanese Name</label>
                    <input type="text" class="form-control" id="japanese_name" placeholder="" name="japanese_name" value="">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="background:#7DCE4C;border:1px solid #7DCE4C">Submit</button>
                </div>
            </form>                
        </div>
        <div class="col-mod-3 col-lg-3"> </div>        
    </div> 
    <div class="clear"></div><hr/>
    <div class="table-responsive col-mod-12">
        <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
            <thead>
                <tr role="row">
                    <th > Name </th>
                    <th >Japanese Name</th>
                    <th >status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $k => $data)
                <tr role="row" cla  ss="odd">
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->japanese_name }}</td>
                    @if($data->status==0)
                        <td> 
                            <form action="{{route('clients-status-change')}}" method="post">
                                <!-- <input id="{{$data->id}}" name="{{$data->id}}" type="hidden" value='{{$data->id}}'/> -->
                                <input id="statusId" name="statusId" type="hidden" value='{{$data->id}}'/>
                                <button type="submit" class="btn btn-danger">Disabled</button>
                            </form> 
                        </td>
                    @else
                        <td> 
                            <form action="{{route('clients-status-change')}}" method="post">
                                <input id="statusId" name="statusId" type="hidden" value='{{$data->id}}'/>
                                <button type="submit" class="btn btn-success" >Enabled</button>
                            </form>    
                        </td>
                    @endif
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
    $('#clientsForm').submit((event)=>{
        const name =  $('#name').val();
        if(name == ''){
            $('#errorname').html("Please Enter Client's Name");
            return false;
        }
        else{
            return true;
        }
    });

  
</script>
@stop