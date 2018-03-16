@extends('layouts.master')
@section('content')
<style> th,td{overflow:hidden;}</style>

<div class="ht-form-control-large">
    <div class="w3-container w3-card-4 w3-round-large w3-margin w3-white w3-padding" style="overflow: hidden;">
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>URI</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            @foreach($routes as $route)
                <tr>
                    <td><a href="{{$route->uri}}">{{$route->uri}}</a></td>
                    <td>{{$route->getName()}}</td>
                    <td>{{$route->getPrefix()}}</td>
                    <td>{{$route->getActionMethod()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
