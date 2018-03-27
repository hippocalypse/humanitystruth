@extends('layouts.master')
@section('content')
<div class="ht-form-control-large">
    <div id="vue_app" class="w3-container w3-round w3-margin w3-white ht-form-control-large">
        <b-tabs class="w3-padding w3-margin">
            <b-tab title="Contact Us" class="w3-margin">
                <p>If you have no sensitive data to transmit, you may email us at  <a href="mailto:admin@humanitystruth.com"><b>admin@humanitystruth.com</b></a></p>
                <p>You may also connect to our simple webchat available at: <a href="https://humanitystruth.com/chat"><b>https://humanitystruth.com/chat</b></a></p>
                <p class="alert alert-info">If you do have sensitive information or otherwise need higher security, please contact us through <a href="https://www.torproject.org/" target="_blank"><b>Tor</b></a> using our secured webchat available at <a href="https://a6x2c12hatc3pjw1pli5r.onion" target="_blank"><b>https://a6x2c12hatc3pjw1pli5r.onion</b></a></p>
            </b-tab>
            
            <b-tab title="Secure-Drop" {{ Request::is('securedrop/help') ? "active" : ""}}>
                <div class="w3-center">
                    <h3>Submitting documents anonymously</h3>
                </div>
                <p><b>Your IP is public: {{$_SERVER['REMOTE_ADDR']}}</b><br>You must connect via <a href="https://www.torproject.org/" target="_blank"><b>Tor</b></a></p>
                <p>HumanitysTruth specializes in pushing censored/suppressed technologies to mass-consciousness.</p>
                <p>The following is the address of our secure site where you can anonymously upload your documents to our editors.</p>
                <div class="alert alert-info">
                    <div><a href="https://wlupld3ptjvsgwqw.onion" target="_blank"><b>https://wlupld3ptjvsgwqw.onion</b></a></div><br>
                    <div>
                        Copy this address into your <a href="https://torproject.org/" target="_blank"><b>Tor Browser</b></a>. When the page loads, you will find further instructions on how to submit files and messages through our securedrop system. We highly recommend further increasing your encryption layer by using our <a href="#"><b>Public PGP Key</b></a>.
                    </div>
                </div>
            </b-tab>

            <b-tab title="Tips" class="w3-margin">
                <div class="w3-container">
                    <p>When accessing the anonymous submission form, <b>adhere to these rules</b>:</p>
                    <ol class="w3-container">
                        <li>
                            Make sure you're always connecting using (https://) a secure socket layer.
                        </li>
                        <li>
                            Download the <a href="https://torproject.org/" target="_blank"><b>Tor Browser</b></a> and tunnel your connection.
                        </li>
                        <li>
                            Further encrypt all sensitive data using our <a href="#"><b>Public PGP Key</b><a>.
                        </li>
                        <li>
                            Download the <a href="https://tails.boum.org/" target="_blank"><b>Tails OS</b></a> to remain anonymous at the hardware level and, especially if you are uploading documents, do not to use your home or work network. Instead, use a public Wi-Fi network in an area where your screen is not visible to security cameras.
                        </li>
                        <li>
                            After accessing SecureDrop, you will be assigned a randomly generated and unique code phrase. If we need to further contact you about the information you have submitted, we will leave a message for you in SecureDrop. The messages can only be accessed using your code name. These messages are the only way we will be able to reach you. Write this down on a piece of paper and never store it digitally.
                        </li>
                        <li class="alert alert-info w3-margin-top">
                            Make sure the information you've got is suppressed and worth publishing. Some examples of the types suppressed intelligence we will push:
                            <ul>
                                <li>Zero-Point Energy</li>
                                <li>Electro/Magneto Gravitics</li>
                                <li>Exo-politics/News</li>
                                <li>Advanced Pharmaceuticals</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </b-tab>
            
            <b-tab title="What to do next?">
                <div class="alert alert-info w3-margin-top">
                    <h4>1. Do not talk about your submission to others</h4>
                    <p>If you have any issues, talk to HumanitysTruth. We are global experts in source protection – it's a complex field. Even those who mean well often do not have the experience or expertise to advise properly.</p>
                </div>
                <div class="alert alert-info">
                    <h4>2. Act normal</h4>
                    <p>If you are a high-risk source, avoid saying anything or doing anything after submitting which might promote suspicion. In particular, you should try to stick to your normal routine and behaviour.</p>
                </div>

                <div class="alert alert-info">
                    <h4>3. Remove traces of your submission</h4>
                    <p>If you are a high-risk source and the computer you prepared your submission on, or uploaded it from, could subsequently be audited in an investigation, we recommend that you format and dispose of the computer hard drive and any other storage media you used.</p>
                    <p>In particular, hard drives retain data after formatting which may be visible to a digital forensics team and flash media (USB sticks, memory cards and SSD drives) retain data even after a secure erasure. If you used flash media to store sensitive data, it is important to destroy the media.</p>
                    <p>If you do this and are a high-risk source you should make sure there are no traces of the clean-up, since such traces themselves may draw suspicion.</p>
                </div>
                <div class="alert alert-info">
                    <h4>4. If you face legal action</h4>
                    <p>If a legal action is brought against you as a result of your submission, there are organisations that may help you. The Courage Foundation is an international organisation dedicated to the protection of journalistic sources. You can find more details at <a href="https://www.couragefound.org">https://www.couragefound.org</a>.</p>
                </div>
            </b-tab>
        </b-tabs>           
    </div>
</div>

<script src="/js/app.js" type="text/javascript"></script>
@stop


