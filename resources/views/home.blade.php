@extends('layouts.admin')

@section('content')
    <div>
        <div class="content-wraper">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('clients-list') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Clients</a></h5>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('projects-list') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Projects</a></h5>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('client-payments-list') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Clients Payments</a></h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('expenses-list') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Expenses</a></h5>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('client-email') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Email Credentials</a></h5>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('client-server') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Server Credentials</a></h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('client-domain') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Domain Control</a></h5>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('client-site') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i>Third Party Sites</a></h5>
                    </div>
                </div>
                {{--<div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h5><a href="{{ route('') }}"><i class="dashboard-icon fa-fw ti-settings text-info"></i></a></h5>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@endsection
