@extends('layouts.master')
@section('content')
<div class="w3-container form-control-large">
    <div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
            <h2>Donate to HumanitysTruth</h2>
            <p>HumanitysTruth is entirely supported by the general public.</p>
            <div class="w3-container w3-padding w3-row">
                <div class="w3-half w3-mobile">
                    <p>Your donations pay for:</p>
                    <ul>
                        <li>Investigative research and development</li>
                        <li>Servers and bandwidth</li>
                        <li>Protective infrastructure</li>
                        <li>Promoting the exposure of suppressed knowledge</li>
                        <li>...</li>
                    </ul>
                </div>

                <div class="w3-half w3-mobile">
                    <p>Here's some affiliates we support monthly:</p>
                    <ul>
                        <li>securedrop.org</li>
                        <li>wikileaks.org</li>
                        <li>siriusdisclosure.com</li>
                        <li>youtube.com/secureteam10</li>
                        <li>...</li>
                    </ul>
                </div>
            </div>

            <!-- Donation payment -->
            <div id="vue_app">
                @csrf
                <donate-component></donate-component>
            </div>
            <script src="/js/app.js" type="text/javascript"></script>
    </div>
</div>
@stop