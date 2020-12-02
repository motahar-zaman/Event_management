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

        <div class="col-md-12">
            <div class="col-md-2 col-lg-2">
                <h3 class="box-title text-success m-b-0">Emails</h3>
                <p class="text-muted m-b-30">List of all Emails</p>
            </div>
            <div class="col-md-10 col-lg-10">
                <form action="{{route('add-email')}}" method="post" enctype="multipart/form-data" id="emailForm">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group row col-md-9" >
                                <div class="col-md-6">
                                    <label for="clientName">Client Name</label>
                                    <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="clientName" name="clientName">
                                        <option value="0">Select</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->name}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="projectName">Project Name</label>
                                    <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="projectName" name="projectName">
                                        <option value="0">Select</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->name}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-md-9">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="email" name="email" required/>
                                </div>
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="password" name="password" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="col-md-12" for="note">Note</label>
                            <textarea class="col-md-12" name="note" id="note"> </textarea>
                        </div>
                    </div>
                    <div class="row text-center">
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
                    <th>Email</th>
                    <th>Password</th>
                    <th>Client Name</th>
                    <th>Project name </th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody>
                @foreach($emails as $k => $data)
                    <tr role="row" cla  ss="odd">
                        <td>{{ $data->created_at }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->password }}</td>
                        <td>{{ $data->client_name }}</td>
                        <td>{{ $data->project_name }}</td>
                        <td>{{ $data->note}}</td>
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
@stop
