@extends('layouts.master')
@section('content')
<div class="w3-container ht-form-control-large">
    <div class="w3-container w3-padding w3-card-4 w3-round w3-margin w3-white">
        <div class="w3-container w3-padding w3-margin">
            <h3 class="w3-center"><strong>HumanitysTruth</strong> is entirely supported by the <strong>general public</strong>. Here's how we spend our funding:</h3>
        </div>
        <div id="donations_pay_for" class="w3-half" style="max-height: 250px;margin-bottom:32px!important"></div>
        <script>
            Morris.Donut({
                element: 'donations_pay_for',
                data: [
                  {value: 15, label: 'Servers/Bandwidth'},
                  {value: 20, label: 'Infrastructure'},
                  {value: 10, label: 'Security'},
                  {value: 10, label: 'Advancing R&D'},
                  {value: 40, label: 'Promoting Leaks'},
                  {value: 5, label: 'Community Donations'}
                ],
                labels: ['test'],
                formatter: function (x) { return x + "%"}
            }).on('click', function(i, row){
                console.log(i, row);
            });
        </script>

        <div id="supported_affiliates" class="w3-half" style="max-height: 250px;margin-bottom:32px!important"></div>
        <script>
            Morris.Donut({
                element: 'supported_affiliates',
                data: [
                  {value: 25, label: 'freedom.press'},
                  {value: 7, label: 'securedrop.org'},
                  {value: 5, label: 'wikileaks.org'},
                  {value: 5, label: 'torproject.org'},
                  {value: 20, label: 'siriusdisclosure.com'},
                  {value: 5, label: 'youtube.com/secureteam10'}
                ],
                formatter: function (x) { return "$" + x + "/mo"}
            }).on('click', function(i, row){
                console.log(i, row);
            });
        </script>
        
        <!-- Donation payment -->
        <div id="vue_app">
            <donate-component></donate-component>
        </div>
    </div>
</div>
@stop