@extends('layouts.master')

@section('content')
<div class="ht-form-control">
    <div class="w3-container w3-padding w3-card-4 w3-round w3-margin w3-white">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="w3-container"><h2 class="w3-padding w3-round-large w3-center w3-black"><b>Registration Form</b></h2></div>
            <div class="w3-container w3-padding">
                <p><input id="email" placeholder=" E-Mail Address" type="email" class="w3-input ht-form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required></p>
                
                
                <input id="phone" placeholder=" Phone and Carrier (optional)" type="number" class="w3-input w3-margin-bottom ht-form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">
                <select id="phone_carrier_id" name="phone_carrier_id" class="w3-light-grey w3-round-large w3-input w3-margin-bottom w3-block" required>
                    @foreach($carriers as $carrier)
                    <option {{$carrier->name == "AT&T" ? "selected" : ""}} value='{{$carrier->id}}'>{{$carrier->name . " (" . $carrier->suffix . ")"}}</option>
                    @endforeach
                </select>
                
                <p><input id="alias" placeholder=" Alias (public)" type="alias" class="w3-input ht-form-control{{ $errors->has('alias') ? ' is-invalid' : '' }}" name="alias" value="{{ old('alias') }}"></p>
                <p><input id="password" placeholder=" Password" type="password" class="w3-input ht-form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required></p>
                <p><input id="password-confirm" placeholder=" Confirm Password" class="w3-input ht-form-control" type="password" name="password_confirmation" required></p>
                <p class="w3-center">
                    <label for="agreement">I agree to the 
                        <b><a target="_blank" href="{{ route('ethics') }}">terms and ethics</a></b>
                    </label>
                    <input style="width: 10%" id="agreement" type="checkbox" class="w3-check" name="agreement" required>
                </p>
                <p><div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITE_KEY')}}"></div></p>
            </div>
            <div class="w3-container">
                <button class="w3-button w3-black w3-round w3-right" type="submit">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@stop