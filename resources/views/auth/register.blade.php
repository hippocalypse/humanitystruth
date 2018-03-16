@extends('layouts.master')

@section('content')
<div class="ht-form-control">
    <div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="w3-container"><h2 class="w3-center w3-black"><strong>Registration Form</strong></h2></div>
            <div class="w3-container w3-padding">
                <p><input id="email" placeholder=" E-Mail Address" type="email" class="ht-form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required></p>
                <p><input id="phone" placeholder=" Phone (optional)" type="number" class="ht-form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}"></p>
                <p><input id="alias" placeholder=" Alias (public, optional)" type="alias" class="ht-form-control{{ $errors->has('alias') ? ' is-invalid' : '' }}" name="alias" value="{{ old('alias') }}"></p>
                <p><input id="password" placeholder=" Password" type="password" class="ht-form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required></p>
                <p><input id="password-confirm" placeholder=" Confirm Password" class="ht-form-control" type="password" name="password_confirmation" required></p>
                <p><div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITE_KEY')}}"></div></p>
            </div>
            <div class="w3-container">
                <button class="w3-button w3-black w3-right" type="submit">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
