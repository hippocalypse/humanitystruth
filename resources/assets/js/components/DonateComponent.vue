<template>
<div class="w3-container w3-center">
    <div class="w3-container w3-center">
        <h3>How much would you like to donate?</h3>
        <div class="w3-container w3-center">
            <button class="w3-button w3-half w3-margin-bottom w3-padding w3-border w3-round-large" v-bind:class="[monthlyMethod ? 'w3-white' : 'w3-blue', '']" v-on:click="onceClick">Once</button>
            <button class="w3-button w3-half w3-margin-bottom w3-padding w3-border w3-round-large" v-bind:class="[monthlyMethod ? 'w3-blue' : 'w3-white', '']" v-on:click="monthlyClick">Monthly</button>
        </div>

        <div class="w3-container">
            <div class="w3-bar">
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==1 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(1)">$1,000</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==2 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(2)">$500</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==3 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(3)">$250</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==4 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(4)">$100</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==5 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(5)">$50</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==6 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(6)">$25</button>
                <button class="w3-button w3-border w3-round-large w3-margin-bottom" v-bind:class="[moneyUnit==7 ? 'w3-blue' : 'w3-white', '']" v-on:click="priceClick(7)">$10</button>
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
            <button class="w3-button w3-red w3-border w3-round-large w3-right w3-mobile" v-on:click="onPaymentModal" >Proceed to Donation Method</button>
        </div>

        <div id="donateMethod" class="w3-modal w3-round">
            <div class="w3-modal-content w3-card-4">
                <div class="w3-container w3-teal"> 
                    <span onclick="getObj('donateMethod').style.display='none'" class="w3-button w3-black w3-display-topright w3-margin-top w3-margin-right">&times;</span>
                    <h2 class="w3-center w3-black">
                        <div class="w3-panel w3-center">
                            <strong>Donation Method</strong>
                        </div>
                    </h2>
                </div>
                <div class="w3-container w3-padding">
                    <div class="w3-hide">
                        <form method="POST" action="https://www.paypal.com/cgi-bin/webscr" role="form" id="paypal_form">
                            <div class="form-group">
                                <input type="hidden" name="cmd" value="_donations">
                                <input type="hidden" name="business" value="admin@humanitystruth.com">
                                <input type="hidden" name="amount" v-model="price" class="pure-number">
                                <input type="hidden" name="return" value="https://humanitystruth.com/donate">
                                <input type="hidden" name="cancel_return" value="https://humanitystruth.com/donate">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info" value="Proceed to PayPal">
                            </div>
                        </form>
                    </div>


                    <b-card no-body>
                      <b-tabs pills card>
                        <b-tab title="Paypal" active>
                          <div class="w3-container w3-padding">
                                <button class="w3-button w3-blue w3-border w3-round-large" v-on:click="onPaypal">Paypal</button>
                            </div>
                        </b-tab>
                        <b-tab title="Bitcoin">
                    <div class="w3-container w3-padding">
                        <div title="Bitcoins are a decentralized, anonymous digital currency that aren't subject to regulations.">
                            <p><button class="w3-button w3-blue w3-border w3-round-large" v-on:click="copy(this)">Bitcoin:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp</button></p>
                            <p><img id='barcode_bitcoin' src="https://api.qrserver.com/v1/create-qr-code/?data=bitcoin:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp&amp;size=150x150" width="150" height="150" /></p>
                        </div>
                    </div>
                        </b-tab>
                       <b-tab title="Monero">
                            <div class="w3-container w3-padding">
                                <div title="Monero is an open-source cryptocurrency that focuses on privacy, decentralisation and scalability.">
                                    <p><button class="w3-button w3-blue w3-border w3-round-large" v-on:click="copy(this)">Monero:3ExxAbqo5FsCXWKZ1mPEwRVZNhWpm7Z9tp</button></p>
                                    <p><img id='barcode_monero' src="https://api.qrserver.com/v1/create-qr-code/?data=monero:4847UcYgMvj3EN7CTWYdduHpMHuRhg2EWjKrq47MvrDNczkrDrjPxXUM5FSXhSBg2SV1HKefXdXf52M5xZY4LvLwLb9YA8B&amp;size=150x150" width="150" height="150" /></p>
                                </div>
                            </div>
                        </b-tab>
                      </b-tabs>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</div>
    


    
 
</template>

<script>
    var prices = [0,1000,500,250,100,50,25,10];
    var pay_types = ["once", "Monthly"];
    var data = {
        price: 0,
        monthlyMethod: 0,
        moneyUnit: 0,
        pay_type: 'once'
        
    };
    export default {

        data: function () {
            return data;
           
        },
        mounted() {
            this.priceClick(6);
        },
        methods: {
            onceClick: function (event) {
                this.monthlyMethod = 0;
            },
            monthlyClick: function (event) {
                this.monthlyMethod = 1;
            },
            priceClick: function (val) {
                this.moneyUnit = val;
                this.price = prices[this.moneyUnit];
            },
            onPaymentModal: function () {
                if(this.price > 0) {
                    document.getElementById('donateMethod').style.display='block';
                }
                
            },
            onPaypal: function() {
                this.pay_type = pay_types[this.monthlyMethod];
                $("#paypal_form").submit();
            }
        }
    }
</script>
