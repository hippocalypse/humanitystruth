<div id="notification" class="notify-top-center" style="display: none;">
    <div class="notify-message" onclick="getObj('notification').style.display='none'">
        <a class="close"><span onclick="getObj('notification').style.display='none'" class="w3-button w3-black w3-display-topright">&times;</span></a>
        <div id="notification-content"></div>
    </div>
</div>

<script>
    @if($errors->all()) //load and show previous pages notification
        error('@foreach($errors->all() as $error)<p>{{$error}}</p>@endforeach');
    @elseif(session('error')) //errors
        error('<p>{{session("error")}}</p>');
    @elseif(session('notify')) //successes
        notify('<p>{{session("notify")}}</p>');
    @elseif(session('status')) //successes from laravel
        notify('<p>{{session("status")}}</p>');
    @elseif(session('warning')) //warnings
        warning('<p>{{session("warning")}}</p>');
    @endif
</script>