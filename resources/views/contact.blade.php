@extends('layouts.master')
@section('content')
<div class="ht-form-control-large">
    <div id="vue_app" class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white ht-form-control-large">
        <b-tabs class="w3-padding w3-margin">
            <b-tab title="Contact Us" selected class="w3-margin">
                <p>If you have no sensitive data to transmit, you may email us at  <a href="mailto:admin@humanitystruth.com"><b>admin@humanitystruth.com</b></a></p>
                <p>You may also connect to our simple webchat available at: <a href="https://humanitystruth.com/chat"><b>https://humanitystruth.com/chat</b></a></p>
                <p class="alert alert-info">If you do have sensitive information or otherwise need higher security, please contact us through <a href="https://www.torproject.org/" target="_blank"><b>Tor</b></a> using our secured webchat available at <a href="https://a6x2c12hatc3pjw1pli5r.onion" target="_blank"><b>https://a6x2c12hatc3pjw1pli5r.onion</b></a></p>
            </b-tab>

            <b-tab title="Tips">
                <h3>Tips for Anonymity</h3>
                <p>Our submission system works hard to preserve your anonymity, but we recommend you also take some of your own precautions. Please review these basic guidelines. </p>
                <div class="alert alert-info">
                        <h4>1. Encrypt your source-data</h4>
                        <p>Add a further layer of encryption (on top of https) to your submission using <a href="#public_secure_drop_key">our public PGP key</a></p>
                </div>
                <div class="alert alert-info">
                    <h4>2. Use <a href="https://www.torproject.org/" target="_blank"><b>Tor</b></a></h4>
                        <p>Tunneling our communications through tor will provide a layer of anonymity to your network traffic.</p>
                </div>
                <div class="alert alert-info">
                    <h4>3. Use <a href="https://tails.boum.org" target="_blank"><b>Tails OS</b></a></h4>
                        <p>If the computer you are uploading from could subsequently be audited in an investigation, consider using a computer that is not easily tied to you. Technical users can also use <a href="https://tails.boum.org">Tails</a> to help ensure you do not leave any records of your submission on the computer.</p>
                </div>
                <div class="alert alert-info">
                        <h4>4. Do not talk about your submission to others</h4>
                        <p>If you have any issues talk to WikiLeaks. We are the global experts in source protection – it is a complex field. Even those who mean well often do not have the experience or expertise to advise properly. This includes other media organisations.</p>
                </div>
                <div class="alert alert-info">
                        <h4>5. Contact us anonymously and directly if you have specific needs</h4>
                        <p>If you have a very large submission, or a submission with a complex format, or are a high-risk source, please chat with us <a href="https://a6x2c12hatc3pjw1pli5r.onion" target="_blank"><b>https://a6x2c12hatc3pjw1pli5r.onion</b></a></p>
                </div>
            </b-tab>

            <b-tab title="Secure-Drop">
                <h3>Tor</h3>
                <p><a href="https://www.torproject.org">Tor</a> is an encrypted anonymising network that makes it harder to intercept internet communications, or see where communications are coming from or going to.</p>
                <p>In order to use the WikiLeaks public submission system as detailed above you can download the Tor Browser Bundle, which is a Firefox-like browser available for Windows, Mac OS X and GNU/Linux and pre-configured to connect using the anonymising system Tor.</p>
                <h4>Tails</h4>
                <p>If you are at high risk and you have the capacity to do so, you can also access the submission system through a secure operating system called <a href="https://tails.boum.org">Tails</a>. Tails is an operating system launched from a USB stick or a DVD that aim to leaves no traces when the computer is shut down after use and automatically routes your internet traffic through Tor. Tails will require you to have either a USB stick or a DVD at least 4GB big and a laptop or desktop computer.</p>

                <div class="page-header">
                        <h1>Submit documents to WikiLeaks</h1>
                        <a class="remove-button" href="#"><span class="glyphicon glyphicon-remove-circle"></span></a>
                </div>
                <p>WikiLeaks publishes documents of political or historical importance that are censored or otherwise suppressed. We specialise in strategic global publishing and large archives.</p>
                <p>The following is the address of our secure site where you can anonymously upload your documents to WikiLeaks editors. You can only access this submissions system through Tor. (See our <a href="#submit_help_tor">Tor tab</a> for more information.) We also advise you to read our <a href="#submit_help_tips">tips for sources</a> before submitting.</p>

                <div class="alert alert-info">
                    <div class="onion-url">wlupld3ptjvsgwqw.onion</div>
                    <div>
                            Copy this address into your Tor browser. Advanced users, if they wish, can also add a further layer of encryption to their submission using <a href="#submit_wlkey">our public PGP key</a>.
                    </div>
                </div>

                <p>If you cannot use Tor, or your submission is very large, or you have specific requirements, WikiLeaks provides several alternative methods. <a href="#submit_help_contact">Contact us</a> to discuss how to proceed.</p>

            </b-tab>

            <b-tab title="What next?">
                <h3>After sending us anonymous information:</h3>

                <div>
                        <h4>1. Do not talk about your submission to others</h4>
                        <p>If you have any issues talk to WikiLeaks. We are the global experts in source protection – it is a complex field. Even those who mean well often do not have the experience or expertise to advise properly. This includes other media organisations.</p>
                </div>

                <div>
                        <h4>2. Act normal</h4>
                        <p>If you are a high-risk source, avoid saying anything or doing anything after submitting which might promote suspicion. In particular, you should try to stick to your normal routine and behaviour.</p>
                </div>

                <div>
                        <h4>3. Remove traces of your submission</h4>
                        <p>If you are a high-risk source and the computer you prepared your submission on, or uploaded it from, could subsequently be audited in an investigation, we recommend that you format and dispose of the computer hard drive and any other storage media you used.</p>
                        <p>In particular, hard drives retain data after formatting which may be visible to a digital forensics team and flash media (USB sticks, memory cards and SSD drives) retain data even after a secure erasure. If you used flash media to store sensitive data, it is important to destroy the media.</p>
                        <p>If you do this and are a high-risk source you should make sure there are no traces of the clean-up, since such traces themselves may draw suspicion.</p>
                        <div>
                                <h4>4. If you face legal action</h4>
                                <p>If a legal action is brought against you as a result of your submission, there are organisations that may help you. The Courage Foundation is an international organisation dedicated to the protection of journalistic sources. You can find more details at <a href="https://www.couragefound.org">https://www.couragefound.org</a>.</p>
                        </div>
                </div>
            </b-tab>
        </b-tabs>           
    </div>
</div>
<script src="/js/app.js" type="text/javascript"></script>
@endsection


