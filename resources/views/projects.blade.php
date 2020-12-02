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
        <div class="col-mod-2 col-lg-2">
            <h3 class="box-title text-success m-b-0">Projects</h3>
            <p class="text-muted m-b-30">List of all Projects</p>
        </div>
        <div class="col-mod-10 col-lg-10">
            <form action="{{route('add-projects')}}" method="post" enctype="multipart/form-data" id="ProjectsForm">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row col-md-9" >
                            <div class="col-md-6">
                                <label for="projectName" class="required-field">Project Name</label>
                                <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="projectName" name="projectName" required>
                                <span class='error' id="Projects_name_error" ></span>
                            </div>
                            <div class="col-md-6">
                                <label for="clientName" class="required-field">Client Name</label>
                                <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="clientName" name="clientName" required>
                                    <option value="">Select</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                                <span class='error' id="Projects_name_error" ></span>
                            </div>
                        </div>
                        <div class="form-group row col-md-9">
                            <div class="col-md-6">
                                <label for="email">Version Control</label>
                                <select class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="versionControl" name="versionControl">
                                    <option value = "">Select Version Control</option>
                                    <option value = "Bitbucket">Bitbucket</option>
                                    <option value = "Git">Git</option>
                                    <option value = "Jira">Jira</option>
                                </select>
                                <span class='error' id="Projects_name_error" ></span>
                            </div>
                            <div class="col-md-6">
                                <label for="password">Repository</label>
                                <input class="custom-select-client " style="border:1px solid #ccc; height:38px; width:100%" id="repository" name="repository"/>
                                <span class='error' id="Projects_name_error" ></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="col-md-12" for="note">Note</label>
                        <textarea class="col-md-12" name="note" id="note"> </textarea>
                    </div>
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
                    <th>Date </th>
                    <th>Project name </th>
                    <th>Client Name</th>
                    <th>Version Control</th>
                    <th>Repository</th>
                    <th>Note</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $k => $data)
                <tr role="row" cla  ss="odd">
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->clients->name }}</td>
                    <td>{{ $data->version_control }}</td>
                    <td>{{ $data->repository }}</td>
                    <td>{{ $data->note }}</td>
                    @if($data->status==0)
                        <td>
                            <form action="{{route('projects-status-change')}}" method="post">
                                <input id="statusId" name="statusId" type="hidden" value='{{$data->id}}'/>
                                <button type="submit" class="btn btn-danger">Disabled</button>
                            </form>
                        </td>
                    @else
                        <td>
                            <form action="{{route('projects-status-change')}}" method="post">
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
@stop
