@extends('layouts.master')
@section('content')
<div class="w3-container w3-padding w3-card-4 w3-round-large w3-margin w3-white">
    <p><strong>UNDER CONSTRUCTION</strong></p>
    <div class="w3-container w3-padding w3-card-4 w3-round w3-margin w3-white">
        <div class="w3-container w3-padding w3-center">
            <h3><strong>Open-Source Research & Development Community</strong></h3>
        </div>
        <div class="w3-container">
            <p>Mainstream education has lied to all of us. You feel it in your core, but why? If we as a species are to overcome this systemic tyranny, we must understand it. In fact, it's this very ignorance that plagues humanity.</p>



            <p>The Lightworkers Union is a collective of free-thinking minds. 
               We're developing an open-source investigative research and development community, wrapped in an app.
               Securely distributing suppressed technology that the global elite
               work hard to silence is our profession.

               Here's some of our Lightworker's Union app features:
            </p>
            <ul>
                <li>hybrid p2p filesharing system for humanitystruth evidence</li>
                <li>mining-for-hire system to utilize idle processing, bandwidth, and virtual hard-drive space</li>
                <li>critical suppressed evidence gets pushed/shared throughout network</li>
                <li>transparent open-source community, with multiple layers of file redundancy</li>
                <li>financing sourced from mining-for-hire operations further fund whistleblowers and suppressed evidence</li>
            </ul>

            <p>Some examples of the suppressed intelligence we risk life and liberty to expose:</p>
            <ul>
                <li>Zero-Point Energy</li>
                <li>Electro/Magneto Gravitics</li>
                <li>Permanent Magnet Pulsed Motor/Generators</li>
                <li>Consciousness-based Technology</li>
                <li>Crystal/Quasi-Crystalline Technologies</li>
                <li>Exo-politics/news</li>
                <li>Resonance/Harmonic Frequencies</li>
                <li>Pharmaceutical Cures</li>
            </ul>
            <p>You may support bringing truth to mass-consciousness in a few ways:</p>
            <ol>
                <li>Join our Lightworkers Union and support the truth with file-persistence plus idle processing, bandwidth, and virtual disk space.<br>
                    (You'll even earn yourself and your preferred investigations coin if you choose to mine crypto)</li>
                <li>Financially support the community with a small donation to HumanitysTruth!</li>
                <li>Join our developers forums and help build various open-source plugins needed for our system.</li>
                <li>If you've got some suppressed technology and are seeking a publishing outlet: Utilize our anonymous submission system.</li>
                <li>Expand your education daily, the truth is only for those who actively seek it. (Joining our community is a great start!)</li>
                <!--<li>Transition away from specializing in a particular subject and executing the same logical process daily. This is how ignorance is bred.</li>-->
            </ol>
        </div>
    </div>
    <div class="downloadbox">
        <p>Choose your Operating System</p>
        <div>
            <div>
                <img src="/img/os/med_win.png" alt="windows">
                <span>
                    <a href="https://bitcoin.org/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win64-setup.exe" id="downloadwinexe">Windows</a>
                    <span><a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win64-setup.exe" class="dl" id="win64exe">64 bit</a> -
                        <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win32-setup.exe" class="dl" id="win32exe">32 bit</a></span>
                </span>
            </div>
            <div>
                <img src="/img/os/med_win.png" alt="windows">
                <span>
                    <a href="https://bitcoin.org/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win64.zip" id="downloadwinzip">Windows (zip)</a>
                    <span><a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win64.zip" class="dl" id="win64zip">64 bit</a> -
                        <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-win32.zip" class="dl" id="win32zip">32 bit</a></span>
                </span>
            </div>
            <div>
                <img src="/img/os/med_osx.png" alt="osx">
                <span>
                    <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-osx.dmg">Mac OS X</a>
                    <span><a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-osx.dmg" class="dl" id="macdmg">dmg</a> -
                        <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-osx64.tar.gz" class="dl" id="mactar">tar.gz</a></span>
                </span>
            </div>
        </div>
        <div>
            <div>
                <img src="/img/os/med_linux.png" alt="linux">
                <span>
                    <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-x86_64-linux-gnu.tar.gz" id="downloadlin">Linux (tgz)</a>
                    <span><a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-x86_64-linux-gnu.tar.gz" class="dl" id="lin64">64 bit</a> -
                        <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-i686-pc-linux-gnu.tar.gz" class="dl" id="lin32">32 bit</a></span>
                </span>
            </div>
            <div>
                <img src="/img/os/arm.png" alt="ARM Linux">
                <span>
                    <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-arm-linux-gnueabihf.tar.gz" class="dl">ARM Linux</a>
                    <span><a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-aarch64-linux-gnu.tar.gz" class="dl" id="lin64arm">64 bit</a> -
                        <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0-arm-linux-gnueabihf.tar.gz" class="dl" id="lin32arm">32 bit</a></span>
                </span>
            </div>
            <div>
                <img src="/img/os/med_ubuntu.svg" alt="ubuntu">
                <span>
                    <a href="https://launchpad.net/~bitcoin/+archive/ubuntu/bitcoin">Ubuntu (PPA)</a>
                </span>
            </div>
        </div>
        <p class="downloadmore">
            <a href="/bin/bitcoin-core-0.16.0/SHA256SUMS.asc" class="dl">Verify release signatures</a><br>
            <a href="/bin/bitcoin-core-0.16.0/bitcoin-0.16.0.torrent" class="dl">Download torrent</a>
            <a href="magnet:?xt=urn:btih:6493ae7a15b4d32bb4eca1dfaf6dcc0c143492cb&amp;dn=bitcoin-core-0.16.0&amp;tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80&amp;tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337&amp;tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&amp;tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969&amp;tr=udp%3A%2F%2Fzer0day.ch%3A1337&amp;tr=udp%3A%2F%2Fexplodie.org%3A6969" class="magnetlink" data-proofer-ignore=""></a><br>
            <a target="_blank" href="https://bitbucket.org/humanitystruth/humanitystruth/src">Git Repository</a><br>
            <a href="/en/version-history">Show version history</a>
        </p>
    </div>
</div>
@stop