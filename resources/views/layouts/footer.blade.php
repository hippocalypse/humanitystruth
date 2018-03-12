<div class="w3-black w3-center">
    <div class="w3-container">
        <div class="w3-container w3-quarter">
            <div class="w3-col w3-center">
                <a href="#top" title="Back to Top">
                    <img id="footer-logo" class="w3-container" src="/data/imgs/logos/humanitystruth.png">
                </a>
                <p>{{$vision}}</p>
            </div>
        </div>

        <div class="w3-container w3-quarter">
            <div class="w3-col w3-center">
                <strong class="w3-container">Lightworkers Union</strong><br>
                <a href="/investigations">{{\App\Investigation::count()}} Investigations</a><br>
                <a href="/files">{{\App\File::count()}} Files</a><br>
                <a href="/dashboard">XX Online / {{\App\User::count()}} Users</a><br>
                <a href="/download">XX Downloads</a><br>
            </div>
        </div>

        <div class="w3-container w3-quarter">
            <div class="w3-col w3-center">
                <strong class="w3-container">Site Links</strong><br>
                <a href="/dev-team">Developers</a><br>
                <a href="/secure-drop">Secure-Drop</a><br>
                <a href="/ethics-policy">Ethics-Policy</a><br>
                <a href="/contact">Contact Us</a><br>
                <a href="/site-map">Site-Map</a>
            </div>
        </div>

        <div class="w3-container w3-quarter">
            <div class="w3-col w3-center">
                <strong class="w3-container">External Links</strong><br>
                <a target="_blank" href="https://www.torproject.org/">Tor</a><br>
                <a target="_blank" href="https://tails.boum.org/">Tails</a> + <a target="_blank" href="https://www.kali.org/">Kali</a><br>
                <a href="/affiliates">Affiliates</a><br><br>
                <div class="w3-container w3-row">
                    <div class="w3-third">
                        <a class="social-icons" href="https://www.facebook.com/" target="_blank" title="HumanitysTruth on Facebook">
                            <img src="/data/imgs/icons/facebook-icon.png" alt="Facebook">
                        </a>
                    </div>
                    <div class="w3-third">
                        <a class="social-icons" href="https://twitter.com/humanitys_truth" target="_blank" title="HumanitysTruth on Twitter">
                            <img src="/data/imgs/icons/twitter-icon.png" alt="Twitter">
                        </a>
                    </div>
                    <!--<div class="w3-quarter">
                        <a class="social-icons" href="https://www.youtube.com/channel/UCzaJBtxNxgtv1Yo_rxliO1A" target="_blank" title="HumanitysTruth on YouTube">
                            <img src="/data/imgs/icons/youtube-icon.png" alt="YouTube">
                        </a>
                    </div>-->
                    <div class="w3-third">
                        <a class="social-icons" href="https://www.instagram.com/humanitystruth/" target="_blank" title="HumanitysTruth on Instagram">
                            <img src="/data/imgs/icons/instagram-icon.png" alt="Instagram">
                        </a>	                    
                    </div>	 
                </div>
            </div>
        </div>
    </div>
    
    <div class="w3-container w3-center">
        <p class="copyright">© <a href="{{route('home')}}">https://humanitystruth.com</a></p> 
        <!--<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=AVOIaP9Rl3xazjAWV1o2e7aRtUkLmch4lVQYSHRctzYUKB4WHEuEjfMtx64d"></script></span>-->
    </div>
</div>

