@extends('layouts.master')

@section('content')
<div class="w3-margin">
    <div class="w3-container w3-round w3-white w3-margin-bottom w3-padding">
        <div class="row">
            <div class="col-md-8">
                @include ('developers::threads._list')

                {{ $threads->render() }}
                
                
            </div>

            <div class="col-md-4">
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
                <div class="w3-container w3-margin w3-padding">
                    <div class="w3-button w3-center w3-block w3-blue w3-round">
                        <a href="{{ route('dev.create')}}">Publish a new Thread</a>
                    </div>
                </div>

                @if (count($trending))
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
        </div>
    </div>
</div>
@stop
