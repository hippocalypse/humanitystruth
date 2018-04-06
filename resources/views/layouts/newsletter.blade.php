@if(!($id = Auth::id()) || !\App\NewsletterSubscription::where("email_id", $id)->count())
<div class="w3-container w3-card-4 w3-padding w3-round w3-white w3-margin-bottom">
    <div class="w3-center w3-container">
        <form id="newsletter_subscription">
            <h3>Subscribe for the latest intelligence and technology leaks!</h3>
            <input {{ $id ? "type='hidden' value='" . Auth::user()->email . "'" : "" }} id="subscribe" name="subscribe" class="w3-input w3-block w3-margin-bottom" type="text" placeholder="Enter your Email" required>
            <input type="submit" class="w3-button w3-round w3-card-4 w3-blue" value="Subscribe">
        </form>
        
       
    </div>
</div>
@endif

@section('post-scripts')
<script>
    $(document).ready(function() {
        $('#newsletter_subscription').on('submit', function (e) {
            e.preventDefault();
            var subscribe = $('#subscribe').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/newsletter/subscribe',
                data: {subscribe: subscribe},
                success: function( msg ) {
                    warning('Verify your subscription via email confirmation..');
                },
                error: function( msg ) {
                    error('Error adding to mailing list..');
                }
            });
        });
    });
</script>
@stop