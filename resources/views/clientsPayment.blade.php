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
            <h3 class="box-title text-success m-b-0">Clients Payments</h3>
            <p class="text-muted m-b-30">List of all Clients Payments</p>
        </div>
        <div class="col-mod-9 col-lg-9">

            <form action="{{route('add-clients-payments')}}" method="post" enctype="multipart/form-data" id="ProjectsForm">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <input id="editId" name="editId" type="hidden" value='{{isset($clientsPayment->id)?$clientsPayment->id:" "}}'>
                        <div class="form-group row col-md-12" >
                            <div class="col-md-4" >
                                <label for="exampleInputPrice"  class="required-field">Client Name</label>
                                <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="clients_name_id" name="clients_name_id" onchange="getProjects()" required>
                                    @if(isset($clientsPayment->clients_name_id))
                                        <option value="{{$clientsPayment->clients_name_id}}">{{ $clientsPayment->clients->name }}</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="">Select</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class='error' id="clientsNameerror" ></span>
                            </div>
                            <div class="col-md-4" >
                                <label for="exampleInputPrice">Project Name</label>
                                @if(isset($clientsPayment->projects_name_id))
                                    <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="Projects_name" name="projects_name_id">
                                        <option value="{{$clientsPayment->projects_name_id}}">{{ $clientsPayment->projects->name }}</option>
                                    </select>
                                @else
                                    <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="Projects_name" name="projects_name_id">
                                        <option value="">Select A Client Name</option>
                                    </select>
                                @endif
                                <span class='error' id="projectsNameError" ></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputPrice" class="required-field">Payment(BDT)</label>
                                    <input type="number" step="0.01" class="form-control" id="Payments_bdt" name="payment_bdt" value="{{isset($clientsPayment->payment_bdt)?$clientsPayment->payment_bdt:''}}" required>
                                    <span class='error' id="Payments_bdt_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row col-md-12" >
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputPrice">Payment(USD)</label>
                                    <input type="number" step="0.01" class="form-control" id="Payments_usd" name="payment_usd" value="{{isset($clientsPayment->payment_usd)?$clientsPayment->payment_usd:''}}">
                                    <span class='error' id="Payments_usd_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputPrice">Payment(JPY)</label>
                                    <input type="number" step="0.01" class="form-control" id="Payments_jpy" name="payment_jpy" value="{{isset($clientsPayment->payment_jpy)?$clientsPayment->payment_jpy:''}}">
                                    <span class='error' id="Payments_bdt_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" id="note" name="note">{{isset($clientsPayment->note)?$clientsPayment->note:''}}</textarea>
                                    <span class='error' id="note_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="background:#7DCE4C;border:1px solid #7DCE4C">Submit</button>
                </div>
            </form>

        </div>
    </div>
    <div class="clear"></div><hr/>
    <div class="table-responsive col-mod-12">
        <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
            <thead>
                <tr role="row">
                    <th>Date</th>
                    <th>Project name</th>
                    <th>Client Name</th>
                    <th>Payment(BDT)</th>
                    <th>Payment(USD)</th>
                    <th>Payment(JPY)</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientsPayments as $k => $data)
                <tr role="row" class="odd">
                    <td>{{ $data->created_at }}</td>
                    <td>@if(isset($data->projects_name_id)){{ $data->projects->name }} @endif</td>
                    <td>{{ $data->clients->name }}</td>
                    <td>{{ $data->payment_bdt }}</td>
                    <td>{{ $data->payment_usd }}</td>
                    <td>{{ $data->payment_jpy }}</td>
                    <td>{{ $data->note }}</td>
                    <td role="row">
                        <button class="btn btn-primary"><a href="{{route('edit-clients-payments', ['id' => $data->id])}}" style="color:#fff">Edit</a></button>
                        <button class="btn btn-danger"><a href="{{route('delete-clients-payments', ['id' => $data->id])}}" style="color:#fff">Delete</a></button>
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

        function getProjects(){
            let clientId = $('#clients_name_id').val();
            $.ajax({
                url: "get-projects",
                data: {id : clientId},
                type: "GET",
                success: function(result){
                    $("#Projects_name").html(result);
                }
            });
        }

    </script>
@stop
