@extends('layouts.master')
@section('content')
<div class="ht-form-control-large">
    <div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white ht-form-control-large">
        <div class="container">
            <b-tabs>
                <b-tab name="Contacting HumanitysTruth" selected>
                    <h3>Contact</h3>
                    <p>Email: admin@humanitystruth.com</p>
                    <p>If you need help using Tor you can contact WikiLeaks for assistance in setting it up using our simple webchat available at: <a href="https://wikileaks.org/talk">https://wikileaks.org/talk</a></p>
                    <p>If you can use Tor, but need to contact WikiLeaks for other reasons use our secured webchat available at <b>http://wlchatc3pjwpli5r.onion</b></p>
                    <p>We recommend contacting us over Tor if you can.</p>
                </b-tab>
                
                <b-tab name="Tips for Anonymous Sources">
                    <h3>Tips</h3>
                    <p>Our submission system works hard to preserve your anonymity, but we recommend you also take some of your own precautions. Please review these basic guidelines. </p>
                    <div>
                            <h4>1. Contact us if you have specific problems</h4>
                            <p>If you have a very large submission, or a submission with a complex format, or are a high-risk source, please <a href="#submit_help_contact">contact us</a>. In our experience it is always possible to find a custom solution for even the most seemingly difficult situations.</p>
                    </div>
                    <div>
                            <h4>2. What computer to use</h4>
                            <p>If the computer you are uploading from could subsequently be audited in an investigation, consider using a computer that is not easily tied to you. Technical users can also use <a href="https://tails.boum.org">Tails</a> to help ensure you do not leave any records of your submission on the computer.</p>
                    </div>
                    <div>
                            <h4>3. Do not talk about your submission to others</h4>
                            <p>If you have any issues talk to WikiLeaks. We are the global experts in source protection – it is a complex field. Even those who mean well often do not have the experience or expertise to advise properly. This includes other media organisations.</p>
                    </div>

                </b-tab>
                
                <b-tab name="Secure-Drop">
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
                
                <b-tab name="After Submitting Anonymously">
                    <h3>After</h3>

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
        <script src="/js/app.js" type="text/javascript"></script>
        </div>
    </div>
</div>
@endsection


