@extends('layouts.master')

@section('side-content')
<div class="w3-container w3-padding w3-round w3-white w3-margin-bottom">
    <a href="{{ route('dev.create')}}" class="w3-button w3-blue w3-round w3-block w3-margin-bottom w3-margin-top">Create Thread</a>
    <a href="/developers/threads" class="w3-button w3-blue w3-round w3-block w3-margin-bottom">Browse All Threads</a>
    @if (auth()->check())
        <a href="/developers/threads?by={{ auth()->user()->alias }}" class="w3-button w3-blue w3-round w3-block w3-margin-bottom">My Threads</a>
    @endif
    <a href="/developers/threads?popular=1" class="w3-button w3-blue w3-round w3-block w3-margin-bottom">Popular Threads</a>
    <a href="/developers/threads?unanswered=1" class="w3-button w3-blue w3-round w3-block w3-margin-bottom">Unanswered Threads</a>

    <div class="w3-dropdown-hover w3-block">
        <div class="w3-button w3-blue w3-round w3-block">Browse Categories</div>
        <div class="w3-dropdown-content w3-white w3-card-4 w3-round w3-padding">
            @foreach (\Modules\Developers\Entities\Channel::all() as $channel)
            <a href="/developers/threads/{{ $channel->slug }}">{{ $channel->name }}</a>
            @endforeach
        </div>
    </div>

    <hr>
    
    <div class="w3-container w3-margin-top">
        <form method="GET" action="/threads/search">
            <div class="w3-container w3-margin-bottom w3-round">
                <input placeholder="Search the developer threads..." name="q" class="w3-block">
            </div>

            <div class="w3-container">
                <button class="w3-button w3-blue w3-round w3-block" type="submit">Search</button>
            </div>
        </form>
    </div>
    
    <hr>

    @if (isset($trending))
        <div class="panel panel-default">
            <div class="panel-heading">
                Trending Threads
            </div>

            <div class="panel-body">
                <ul class="list-group">
                    @foreach ($trending as $thread)
                        <li class="list-group-item">
                            <a href="{{ url($thread->path) }}">
                                {{ $thread->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@stop