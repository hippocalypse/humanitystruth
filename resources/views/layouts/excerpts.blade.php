<?php $excerpt = \App\Excerpt::inRandomOrder()->get()[0]; ?>
<div class="w3-container">
    <h3>{{$excerpt->content}}</h3>
    <p class="w3-right"> - {{$excerpt->author}}</p>
</div>