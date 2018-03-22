@extends('layouts.master')

@section('content')
<div class="ht-form-control">
    <div class="w3-container w3-card-4 w3-round w3-margin w3-white">
        <div class="w3-container">
            <h2 class="w3-center w3-black">
                <div class="w3-panel w3-center">
                    <strong>Two-Factor Authentication</strong>
                </div>
            </h2>
        </div>
        <form method="POST" action="/two-step">
            @csrf
            <div class="w3-container w3-padding">
                <p><input id="sms_code" placeholder="Enter the text-code" class="ht-form-control{{ $errors->has('sms_code') ? ' is-invalid' : '' }}" name="sms_code" value="{{ old('sms_code') }}" required></p>
                <p>We sent the code to: {{$user->smsAddress()}}</p>
                <p>
                    <button class="w3-button w3-black">Change Carrier Suffix</button>
                    <button class="w3-button w3-black">Resend SMS</button>
                </p>
            </div>

            <div class="w3-container">
                <button class="w3-button w3-black w3-right" type="submit">Verify</button>
            </div>
        </form>
    </div>
</div>
@stop
