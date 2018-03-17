@extends('layouts.master')

@section('content')
<script type="text/javascript">
    var iv = false;
    var ix = Math.random().toString(32).substr(2);
    var startUploads = function () {
        window.location.hash = '#top';
        iv = window.setTimeout(trackUploads, 1000);
    }
    var trackUploads = function () {

        $.ajax({
            url: "/progress",
            type: "GET",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("xid", ix);
            },
            success: function (data, status, xhr) {
                if (data.state == 'done' || data.received >= data.size) {
                    $("#progressBar").css("width", "100%").html("done");
                    window.clearTimeout(iv);
                    window.top.location = "/success.html";
                } else if (data.state == 'done' || data.state == 'uploading') {
                    $("div.progress").removeClass("hidden");
                    var p = Math.floor(100 * (data.received / data.size));
                    $("#progressBar").css("width", p + "%").html(p + "%");
                    iv = window.setTimeout(trackUploads, 1000);

                }

            },
            async: true
        });
    }

    $(document).ready(function () {
        $("#xid").val(ix);
        $("#uploadForm").attr("action", "/upload?xid=" + ix);

        $("#addMorePlaceholder").html('<a href="#" id="addMore">Add more files</a>');
        $("#uploadForm").attr("target", "uploadTarget");

        $("#addMore").click(function () {
            $("#uploadGroup").append($('<input type="file" name="file[]" id="file" multiple />'));
        })
    });

</script>

<div class="ht-form-control-large">
    <div class="w3-container w3-card-4 w3-round w3-margin w3-white w3-padding">
        <h2 class="w3-center">Anonymous Submission Upload</h2>
        <form enctype="multipart/form-data" method="post" action="/upload" class="form-horizontal" role="form" id="uploadForm" onsubmit="startUploads()">
            <input type="hidden" name="xid" id="xid" value="xid" />
            
            <label for="file">Select files to upload</label>
            
            <div id="uploadGroup ">
                <input type="file" name="file[]" id="file" multiple />
            </div>
            <div id="addMorePlaceholder"></div>
            
            <div class="progress hidden">
                <div class="progress-bar" role="progressbar" id="progressBar">0%</div>
            </div>
            
            <div>
                <p class="notes"><strong>Note:</strong>This interface has a progress report for your upload if you enable Javascript. It will still upload properly without Javascript.   </p> 
                <p class="notes"><b>Note:</b> We encrypt your submission on upload, but you may, if able, further encrypt using <a target="_blank" href="submission-key">our public PGP key</a>. Our PGP key's fingerprint is A04C 5E09 ED02 B328 03EB 6116 93ED 732E 9231 8DBA</p>
                <p class="notes">We also encrypt all information within the form. Although no fields are mandatory we recommend providing this information where possible.</p>
            </div>
            
            <div class="alert alert-info" style="margin: 0">
                To ensure WikiLeaks can publish with maximum impact while protecting sources, 
                please don't contact anyone else, including other media, about your submission.
                <br/>
                If you have any questions, you can <a href="https://wlchatc3pjwpli5r.onion/"><b>chat with the WikiLeaks editorial office here</b></a>.
            </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>What are the main subjects or topics that this submission concerns?</div>
                        <div class="fmore">
                        </div>
                        <div><textarea name="topics" id="topics" class="multiligne" style="height: 70px" autocomplete="off"></textarea></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Has this material been published before, and if so, where?</div>
                        <div class="fmore">
                            (describe how you know it has not been published elsewhere - for material under censorship attack, or accidentily exposed, please list the URLs or publication issue and date concerned)</div>
                        <div><input type="text" name="alreadypublished" id="alreadypublished" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Which organisations, groups or individuals are involved in this material?</div>
                        <div class="fmore">
                            (comma separated list)</div>
                        <div><input type="text" name="organisations" id="organisation" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Which organisations, groups or individuals would officially have access to this material?</div>
                        <div class="fmore">
                            (ie is it officially distributed throughout all people in organisation x or to multiple people in a group of organisations, or just to a few people etc, and who are they all?)</div>
                        <div><input type="text" name="whohaveaccess" id="organisation" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>What is the threat to the sources?</div>
                        <div class="fmore">
                            (material can be obtained by one or more sources from an organisation and flow through others before it comes to us, what are the risks to these people, that we need to be aware of, or are there none at all?)</div>
                        <div><input type="text" name="threat" id="threat" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Necessary publication timeframe:</div>
                        <div class="fmore">
                            If there is some urgency in publishing this material you can set an urgency time here. Please describe these reasons below to ensure WikiLeaks can attempt to adhere to this.</div>
                        <div><select name="timeframe" id="timeframe" class="freetext" value=""><option value="1">within up to two weeks</option><option value="2">within two months</option><option value="3" selected="selected">whenever</option></select></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>What's the reason for choosing this timeframe?</div>
                        <div class="fmore">
                        </div>
                        <div><input type="text" name="timeframe_reason" id="timeframe_reason" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>If your submission is relevant to a current issue, please provide details including urls about the current event.</div>
                        <div class="fmore">
                        </div>
                        <div><textarea name="currentissue" id="currentissue" class="multiligne" style="height: 70px" autocomplete="off"></textarea></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Do <em>not</em> publish before this date:</div>
                        <div class="fmore">
                            (We will hold back the publication until AFTER this date, incase, for example, you need to leave your job first. if the date is conditional on some event, please leave the field and describe the event in your "instructions to Wikileaks staff")</div>
                        <div>Day: <select name="notbefore_day" id="notbefore_day" autocomplete="off">      <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>      <option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>      <option>21</option><option>22</option><option>23</option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option></select> Month: <select name="notbefore_month" id="notbefore_month" autocomplete="off">      <option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select> Year: <select name="notbefore_year" id="notbefore_year" autocomplete="off"> <option>2015</option>  <option>2016</option>  <option>2017</option>  <option>2018</option></select></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>When was the material created?</div>
                        <div class="fmore">
                            (a year or date range is fine)</div>
                        <div><input type="text" name="creationdate" id="creationdate" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Provide any specific details or methods you think will assist in verifying your submission.</div>
                        <div class="fmore">
                        </div>
                        <div><input type="text" name="howtoverify" id="howtoverify" maxlength="255" class="freetext" value="" autocomplete="off"/></div>
                    </div>  <div class="col-md-2"></div>
                </div><div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 field">
                        <div>Any further information or instructions to WikiLeaks staff for handling and publishing of this material.</div>
                        <div class="fmore">
                        </div>
                        <div><textarea name="handlinginstructions" id="handlinginstuctions" class="multiligne" autocomplete="off"></textarea></div>
                    </div>  <div class="col-md-2"></div>
                </div>

                <div class="row">
                    <div class="col-md-8" style="padding: 16px 0px">
                        <div class="footer">
                            <p>Before you submit, check you have selected any files you wish to upload</p>
                            <input class="btn btn-primary" type="submit" value="Submit documents and form now" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
