@extends('layouts.master')

@section('content')
<div class="ht-form-control-large">
    <div id="vue_app" class="w3-container w3-round w3-margin w3-card-4 w3-white ht-form-control-large">
            <h3 class='w3-center'>Chat with us!</h3>
            <hr>
            <ul v-if="messages.length > 0">
                <li v-repeat="message: messages">
                    @{{ message }}
                </li>
            </ul>
            
    </div>
</div>
@stop

@section('post-scripts')
<!--<script src="/js/app.js" type="text/javascript"></script>-->
<script type="text/javascript">
    var app = new Vue({
        el: "vue_app",
        ready: function() {
            self = this;
            var socket = io('http://localhost:3000');
            socket.on('public:ChatMessage', function(message) {
                console.log(message);
                
                self.messages.push(message);
                
            });
            
        },
        data: {
            messages: [
                "Welcome to our <b>public</b> chatroom."
            ]
        },
        
        methods: {
            
            
        }
    });
    </script>
@stop
