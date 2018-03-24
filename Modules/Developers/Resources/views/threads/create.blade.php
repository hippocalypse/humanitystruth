@extends('layouts.master')

@section('content')
<div class="ht-form-control">
    <div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white ht-form-control">
        <div class="w3-container">
            <div class="panel-heading">Create a New Thread</div>

            <div class="panel-body">
                <form method="POST" action="{{route('dev.publish')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea class="w3-block" style="min-height: 100px"></textarea>
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