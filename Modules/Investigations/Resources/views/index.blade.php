@extends('layouts.master')

@section('content')

<div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
    <h3 class="w3-center">
        Priority Analysis <strike>Conspiracy Theory</strike>
    </h3>
    <ul>
        @foreach($investigations as $investigation)
        <li>
            <a href="investigations/{{$investigation->id}}">{{$investigation->title}}</a>
        </li>
        @endforeach
    </ul>
</div>

@stop