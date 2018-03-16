@extends('layouts.master')

@section('content')
<div class="ht-form-control">
    <div class="w3-container w3-card-4 w3-round-large w3-margin w3-white">
        <div class="w3-container">
            <h2 class="w3-center w3-black">
                <div class="w3-panel w3-center">
                    <strong>Login</strong>
                </div>
            </h2>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="w3-container w3-padding">
                <div class="w3-col w3-half">
                    <p><input id="email" placeholder=" Email or Phone" type="email" class="ht-form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus></p>
                    <p><input id="password" placeholder=" Password" type="password" class="ht-form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required></p>
                </div>
                <div class="w3-col w3-half">
                    <p class="w3-center"><a href="{{ route('password.request') }}"><strong>Forgot Your Password?</strong></a></p>
                   
                    <p class="w3-center">
                        <label for="remember">Remember Me</label>
                        <input style="width: 10%" id="remember" type="checkbox" class="w3-check" name="remember">
                    </p>
                    
                </div>
            </div>

            <div class="w3-container">
                <button class="w3-button w3-black w3-right" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
