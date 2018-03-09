@extends('layouts.master')
<?php
    $vision = "An open-source intelligence community promoting a decentralized economy of abundance for all humanity on earth by exposing suppressed knowledge.";
?>
@section('content')

<div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
    <h1>Affilates</h1>
    <div class="w3-container w3-padding w3-row">
        <div class="w3-col s12 m10 l7 ">
            @foreach($affiliates as $affiliate)
                <a href="{{$affiliate->website}}" target="_blank" ><img class="w3-margin-bottom w3-padding" src="{{asset('uploads/'.$affiliate->logo)}}" width="150px" height="60px;"></a>
            @endforeach
        </div>

    </div>
</div>    
        
@endsection