@extends('layouts.master')
@section('content')
    <div class="w3-container w3-card-4 w3-round w3-margin w3-padding w3-white">
        <div id="wrapper" class="w3-padding w3-container">
            @include('backend::layouts.menubar')
            <div class="w3-margin-top"></div>
            @yield('backend.content')
        </div>
    </div>
@stop

