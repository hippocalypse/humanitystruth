<template>
    <div class="w3-container w3-center">
        <div class="w3-container w3-center">
            <h3 class="w3-margin"><strong>How much would you like to donate?</strong></h3>
            <div class="w3-container w3-center">
                <button class="w3-button w3-half w3-margin-bottom w3-padding w3-border w3-round-large" v-bind:class="[tx_key ? 'w3-white' : 'w3-blue', '']" v-on:click="onceClick">Once</button>
                <button class="w3-button w3-half w3-margin-bottom w3-padding w3-border w3-round-large" v-bind:class="[tx_key ? 'w3-blue' : 'w3-white', '']" v-on:click="monthlyClick">Monthly</button>
            </div>

            <div class="w3-container">
                <div class="w3-bar">
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==0 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(0)">$1,000</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==1 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(1)">$500</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==2 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(2)">$250</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==3 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(3)">$100</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==4 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(4)">$50</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==5 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(5)">$25</button>
                    <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[prices_key==6 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(6)">$10</button>
                </div>

                <div class="w3-container w3-light-gray w3-border w3-round-large w3-margin-bottom">
                    <div class="w3-half w3-padding">Custom Amount:</div>
                    <div class="w3-half"><input id="custom" class="w3-input w3-center w3-light-gray w3-mobile" type="number" v-model="price"></div>
                </div>
            </div>

            <div class="w3-container w3-center w3-margin-bottom">
                <label for="subscribe">Subscribe to significant intelligence leaks!</label>
                <input id="subscribe" type="checkbox" class="w3-check w3-margin-right">
            </div>

            <div class="w3-container w3-center w3-margin-bottom">
                <h3><strong>Donation Method</strong></h3>

                <div class="w3-container w3-padding">
                    <div class="w3-hide">
                        <form method="POST" action="https://www.paypal.com/cgi-bin/webscr" id="donate_form">
                                <input type="hidden" name="cmd" value="_donations">
                                <input type="hidden" name="business" value="admin@humanitystruth.com">
                                <input type="hidden" name="amount" v-model="price">
                                <input type="hidden" name="item_number" v-model="subscribe">
                                <input type="hidden" name="return" value="https://humanitystruth.com/donate">
                                <input type="hidden" name="cancel_return" value="https://humanitystruth.com/donate">
                                <input type="submit">
                        </form>
                        <form method="POST" action="https://www.paypal.com/cgi-bin/webscr" id="monthly_donate_form">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions">
                            <input type="hidden" name="business" value="admin@humanitystruth.com">
                            <!-- Set the terms of the regular subscription. -->
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="a3" v-model="price">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="M">
                            <input type="hidden" name="item_name" value="Monthly Donation to HumanitysTruth">
                            <input type="hidden" name="item_number" v-model="subscribe">
                            <!-- Set recurring payments until canceled. -->
                            <input type="hidden" name="src" value="1">
                            <input type="hidden" name="return" value="https://humanitystruth.com/donate">
                            <input type="hidden" name="cancel_return" value="https://humanitystruth.com/donate">
                        </form>
                    </div>


                    <b-tabs>
                        <b-tab title="Paypal" active>
                            <div class="w3-container w3-padding w3-margin">
                                <button class="w3-button w3-red w3-border w3-round-large" v-on:click="onPaypal">Donate with Paypal</button>
                            </div>
                        </b-tab>

                        <b-tab title="Bitcoin">
                            <div class="w3-container w3-padding w3-margin-top">
                                <div title="Bitcoins are a decentralized, anonymous digital currency that aren't subject to regulations.">

                                        <p><a href="bitcoin:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp"><button class="w3-button w3-red w3-border w3-round-large" style="max-width: 100%;overflow-wrap: break-word;white-space: normal;">Bitcoin:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp</button></a></p>
                                        <p><img id='barcode_bitcoin' src="https://api.qrserver.com/v1/create-qr-code/?data=bitcoin:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp&amp;size=150x150" width="150" height="150" /></p>

                                </div>
                            </div>
                        </b-tab>

                        <b-tab title="Monero">
                            <div class="w3-container w3-padding w3-margin-top">
                                <div title="Monero is an open-source cryptocurrency that focuses on privacy, decentralisation and scalability.">
                                    <p><a href="monero:4847UcYgMvj3EN7CTWYdduHpMHuRhg2EWjKrq47MvrDNczkrDrjPxXUM5FSXhSBg2SV1HKefXdXf52M5xZY4LvLwLb9YA8B"><button class="w3-button w3-red w3-border w3-round-large" style="max-width: 100%;overflow-wrap: break-word;white-space: normal;">Monero:4847UcYgMvj3EN7CTWYdduHpMHuRhg2EWjKrq47MvrDNczkrDrjPxXUM5FSXhSBg2SV1HKefXdXf52M5xZY4LvLwLb9YA8B</button></a></p>
                                    <p><img id='barcode_monero' src="https://api.qrserver.com/v1/create-qr-code/?data=monero:4847UcYgMvj3EN7CTWYdduHpMHuRhg2EWjKrq47MvrDNczkrDrjPxXUM5FSXhSBg2SV1HKefXdXf52M5xZY4LvLwLb9YA8B&amp;size=150x150" width="150" height="150" /></p>
                                </div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let prices = [1000,500,250,100,50,25,10];
    let data = {
        price: 0,
        tx_key: 0,
        prices_key: 0,
        subscribe: ""
    };
    export default {

        data: function () {
            return data;
           
        },
        mounted() {
            this.priceClick(5);
        },
        methods: {
            onceClick: function (event) {
                this.tx_key = 0;
            },
            monthlyClick: function (event) {
                this.tx_key = 1;
            },
            priceClick: function (val) {
                this.prices_key = val;
                this.price = prices[this.prices_key];
            },
            onPaypal: function() {
                if(this.price > 0) {
                    if($("#subscribe").checked) {
                        this.subscribe = "subscribe";
                    }

                    
                    if(this.tx_key == 0) $("#donate_form").submit();
                    if(this.tx_key == 1) $("#monthly_donate_form").submit();
                    //
                }
            }
        }
    }
</script>
