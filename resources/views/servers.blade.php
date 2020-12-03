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
            <div class="col-md-1 col-lg-1">
                <h3 class="box-title text-success m-b-0">Servers</h3>
                <p class="text-muted m-b-30">List of all Servers</p>
            </div>
            <div class="col-md-11 col-lg-11">
                <form action="{{route('add-server')}}" method="post" enctype="multipart/form-data" id="emailForm">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="clientName">Client Name</label>
                            <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="clientName" name="clientName">
                                <option value="0">Select</option>
                                @foreach($clients as $client)
                                    <option value="{{$client->name}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="projectName">Project Name</label>
                            <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="projectName" name="projectName">
                                <option value="0">Select</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->name}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="ip" class="required-field">IP Address</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="ip" name="ip" required/>
                        </div>

                        <div class="col-md-3">
                            <label for="url" class="required-field">URL</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="url" name="url" required/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="user" class="required-field">User</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="user" name="user" required/>
                        </div>

                        <div class="col-md-3">
                            <label for="password" class="required-field">Password</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="password" name="password" required/>
                        </div>

                        <div class="col-md-3">
                            <label for="port">Port</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="port" name="port"/>
                        </div>

                        <div class="col-md-3">
                            <label for="dbLink">DB Link</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="dbLink" name="dbLink"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="dbUser">DB User</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="dbUser" name="dbUser"/>
                        </div>

                        <div class="col-md-3">
                            <label for="dbPass">DB Password</label>
                            <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="dbPass" name="dbPass"/>
                        </div>

                        <div class="col-md-4">
                            <label for="note">Note</label>
                            <textarea class="col-md-12" name="note" id="note"> </textarea>
                        </div>
                        <div class="col-md-2 text-center" style=" padding-top: 30px">
                            <button type="submit" class="btn btn-primary" style="background:#7DCE4C;border:1px solid #7DCE4C">Submit</button>
                        </div>
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
                        <th>Client Name</th>
                        <th>Project name </th>
                        <th>IP</th>
                        <th>URL</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Port</th>
                        <th>DB Link</th>
                        <th>DB User</th>
                        <th>DB Password</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servers as $k => $data)
                        <tr role="row" cla  ss="odd">
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->client_name }}</td>
                            <td>{{ $data->project_name }}</td>
                            <td>{{ $data->ip_address }}</td>
                            <td>@if(isset($data->url)) <a target="_blank" href="{{ $data->url }}">{{ $data->url }}</a> @endif</td>
                            <td>{{ $data->user_name }}</td>
                            <td>{{ $data->password }}</td>
                            <td>{{ $data->port }}</td>
                            <td>@if(isset($data->db_link)) <a target="_blank" href="{{ $data->db_link }}">{{ $data->db_link }}</a> @endif</td>
                            <td>{{ $data->db_user }}</td>
                            <td>{{ $data->db_password }}</td>
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
