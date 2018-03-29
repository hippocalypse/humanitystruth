@extends('developers::layouts.master')

@section('content')
<div id="vue_app" class="w3-container ht-form-control-large">
    <div class="w3-container w3-padding w3-card-4 w3-round w3-margin w3-white">
        <thread-view :thread="{{ $thread }}" inline-template>
            <div>
                <div class="w3-container w3-padding w3-round w3-white w3-margin-bottom">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->alias }}</a>, and currently
                                has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>

                                <button class="btn btn-default"
                                        v-if="authorize('isAdmin')"
                                        @click="toggleLock"
                                        v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div>
                            @include ('developers::threads._question')

                            <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                        </div>
                    </div>
                </div>
            </div>
        </thread-view>
    </div>
</div>
@stop

@section('post-scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@stop