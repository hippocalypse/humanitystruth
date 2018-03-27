@extends('developers::layouts.master')

@section('content')
<div class="ht-form-control">
    <div id="vue_app" class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white ht-form-control">
        <div class="w3-container">
            <h3 class="w3-center">Create a New Thread</h3>

            <div class="panel-body">
                <form method="POST" action="{{route('dev.publish')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="channel_id">Choose a Category:</label>
                        <select name="channel_id" id="channel_id" class="form-control" required>
                            <option value="">Choose One...</option>

                            @foreach (\Modules\Developers\Entities\Channel::all() as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                    {{ $channel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="body">Body:</label>
                        <wysiwyg name="body"></wysiwyg>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITE_KEY')}}"></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop