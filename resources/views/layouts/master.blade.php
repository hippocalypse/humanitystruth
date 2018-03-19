<?php
    $vision = "An open-source intelligence community promoting a decentralized economy of abundance for all humanity on earth by exposing suppressed knowledge.";
?>

<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$vision}}">
    <title>Humanitys Truth</title>
    
    @include('layouts.head')

    @include('layouts.notification')
    
    @include('layouts.banner')
    
    @include('layouts.menubar')
    

    <body>
        <div class="w3-row">
            <div class="w3-threequarter w3-col w3-margin-bottom">
                @yield('content')
            </div>

            <div id="side-panel" class="w3-quarter w3-col">
                <div class="w3-margin">
                    <div class="w3-container w3-padding w3-round w3-white">
                        @include('layouts.excerpts')
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footer')
    </body>
    
</html>








