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
            <div class="w3-threequarter w3-col">
                @yield('content')
            </div>

            <div id="side-panel" class="w3-quarter w3-col">
                <div class="w3-margin">
                    
                    @yield('side-content')
                    
                    <div class="w3-container w3-card-4 w3-padding w3-round w3-white w3-margin-bottom">
                        @include('layouts.excerpts')
                    </div>
                    
                    @include('layouts.investigation-topics')
                    
                    @include('layouts.newsletter')
                    
                </div>
            </div>
        </div>
        @yield('post-scripts')
        
        @include('layouts.footer')
        
        <!-- Supporting the Internet Defense League -->
        <script type="text/javascript">
            window._idl = {};
            _idl.variant = "modal";
            (function() {
                var idl = document.createElement('script');
                idl.async = true;
                idl.src = 'https://members.internetdefenseleague.org/include/?url=' + (_idl.url || '') + '&campaign=' + (_idl.campaign || '') + '&variant=' + (_idl.variant || 'modal');
                document.getElementsByTagName('body')[0].appendChild(idl);
            })();
        </script>
        
    </body>
    
</html>








