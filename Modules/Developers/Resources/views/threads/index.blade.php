@extends('developers::layouts.master')

@section('content')
<div class="w3-margin">
    <div class="w3-container w3-round w3-white w3-margin-bottom w3-padding">

        @include ('developers::threads._list')

        {{ $threads->render() }}

    </div>
</div>
@stop
