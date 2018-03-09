@extends('layouts.master')
@section('content')
<div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
    <h1 class="w3-centered">Affilates</h1>
    <div class="w3-container w3-padding w3-row">
        @foreach($affiliates as $affiliate)
            <a class="w3-centered" href="{{$affiliate->website}}" target="_blank" >
                <img src="{{asset('data/imgs/logos'.$affiliate->logo)}}" width="150px" height="150px;">
            </a>
            @if($affiliate->account_id) 
            <a class="w3-centered" href="#"><!-- link to users dashboard -->
                {{\App\User::find($affiliate->account_id)->alias}}
            </a>
            @endif
        @endforeach
    </div>
</div>
@stop