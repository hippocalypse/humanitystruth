@extends('layouts.master')
@section('content')
<div class="w3-container w3-padding w3-card-4 w3-round w3-margin w3-white">
    <h1 class="w3-centered">Affilates</h1>
    <div class="w3-container w3-padding w3-row w3-mobile">

        @foreach($affiliates as $affiliate)
                    <a class="w3-center w3-padding-large w3-mobile" href="{{$affiliate->website}}" target="_blank" >
                        <img class="ht-affiliates" src="{{asset('data/imgs/logos/'.$affiliate->logo)}}">
                    </a>
                    @if($affiliate->account_id)
                    <br>
                    <a class="w3-centered" href="#"><!-- link to users dashboard -->
                        {{\App\User::find($affiliate->account_id)->alias}}
                    </a>
                    @endif
        @endforeach
    </div>
</div>
@stop