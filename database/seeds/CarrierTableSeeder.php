<?php

use Illuminate\Database\Seeder;
use App\Carrier;

class CarrierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return [
            Carrier::create(['name' => '3 River Wireless',          'suffix' => 'sms.3rivers.net']),
            Carrier::create(['name' => 'ACS Wireless',              'suffix' => 'paging.acswireless.com']),
            Carrier::create(['name' => 'Alltel',                    'suffix' => 'message.alltel.com']),
            Carrier::create(['name' => 'AT&T',                      'suffix' => 'txt.att.net']),
            Carrier::create(['name' => 'Bell Mobility',             'suffix' => 'txt.bellmobility.ca']),
            Carrier::create(['name' => 'Bell Mobility (Canada)',    'suffix' => 'txt.bell.ca']),
            Carrier::create(['name' => 'Blue Sky Frog',             'suffix' => 'blueskyfrog.com']),
            Carrier::create(['name' => 'Bluegrass Cellular',        'suffix' => 'sms.bluecell.com']),
            Carrier::create(['name' => 'Boost Mobile',              'suffix' => 'myboostmobile.com']),
            Carrier::create(['name' => 'BPL Mobile',                'suffix' => 'bplmobile.com']),
            Carrier::create(['name' => 'Carolina West Wireless',    'suffix' => 'cwwsms.com']),
            Carrier::create(['name' => 'Cellular One',              'suffix' => 'mobile.celloneusa.com']),
            Carrier::create(['name' => 'Cellular South',            'suffix' => 'csouth1.com']),
            Carrier::create(['name' => 'Centennial Wireless',       'suffix' => 'cwemail.com']),
            Carrier::create(['name' => 'CenturyTel',                'suffix' => 'messaging.centurytel.net']),
            Carrier::create(['name' => 'Cingular (Now AT&T)',       'suffix' => 'txt.att.net']),
            Carrier::create(['name' => 'Clearnet',                  'suffix' => 'msg.clearnet.com']),
            Carrier::create(['name' => 'Comcast',                   'suffix' => 'comcastpcs.textmsg.com']),
            Carrier::create(['name' => 'Corr Wireless Communications', 'suffix' => 'corrwireless.net']),
            Carrier::create(['name' => 'Crickett Wireless',         'suffix' => 'sms.mycricket.com']),
            Carrier::create(['name' => 'Dobson',                    'suffix' => 'mobile.dobson.net']),
            Carrier::create(['name' => 'Edge Wireless',             'suffix' => 'sms.edgewireless.com']),
            Carrier::create(['name' => 'Fido',                      'suffix' => 'fido.ca']),
            Carrier::create(['name' => 'Golden Telecom',            'suffix' => 'sms.goldentele.com']),
            Carrier::create(['name' => 'Helio',                     'suffix' => 'messaging.sprintpcs.com']),
            Carrier::create(['name' => 'Houston Cellular',          'suffix' => 'text.houstoncellular.net']),
            Carrier::create(['name' => 'Idea Cellular',             'suffix' => 'ideacellular.net']),
            Carrier::create(['name' => 'Illinois Valley Cellular',  'suffix' => 'ivctext.com']),
            Carrier::create(['name' => 'Inland Cellular Telephone', 'suffix' => 'inlandlink.com']),
            Carrier::create(['name' => 'MCI',                       'suffix' => 'pagemci.com']),
            Carrier::create(['name' => 'Metrocall',                 'suffix' => 'page.metrocall.com']),
            Carrier::create(['name' => 'Metrocall 2-way',           'suffix' => 'my2way.com']),
            Carrier::create(['name' => 'Metro PCS',                 'suffix' => 'mymetropcs.com']),
            Carrier::create(['name' => 'Microcell',                 'suffix' => 'fido.ca']),
            Carrier::create(['name' => 'Midwest Wireless',          'suffix' => 'clearlydigital.com']),
            Carrier::create(['name' => 'Mobilcomm',                 'suffix' => 'mobilecomm.net']),
            Carrier::create(['name' => 'MTS',                       'suffix' => 'text.mtsmobility.com']),
            Carrier::create(['name' => 'Nextel',                    'suffix' => 'messaging.nextel.com']),
            Carrier::create(['name' => 'OnlineBeep',                'suffix' => 'onlinebeep.net']), 
            Carrier::create(['name' => 'PCS One',                   'suffix' => 'pcsone.net']),
            Carrier::create(['name' => 'Presidents Choice',         'suffix' => 'txt.bell.ca']),
            Carrier::create(['name' => 'Public Service Cellular',   'suffix' => 'sms.pscel.com']),
            Carrier::create(['name' => 'Qwest',                     'suffix' => 'qwestmp.com']),
            Carrier::create(['name' => 'Rogers AT&T Wireless',      'suffix' => 'pcs.rogers.com']),
            Carrier::create(['name' => 'Rogers Canada',             'suffix' => 'pcs.rogers.com']),
            Carrier::create(['name' => 'Satellink',                 'suffix' => '.pageme@satellink.net']),
            Carrier::create(['name' => 'Solo Mobile',               'suffix' => 'txt.bell.ca']),
            Carrier::create(['name' => 'Southwestern Bell',         'suffix' => 'email.swbw.com']),
            Carrier::create(['name' => 'Sprint',                    'suffix' => 'messaging.sprintpcs.com']),
            Carrier::create(['name' => 'Sumcom',                    'suffix' => 'tms.suncom.com']),
            Carrier::create(['name' => 'Surewest Communicaitons',   'suffix' => 'mobile.surewest.com']),
            Carrier::create(['name' => 'T-Mobile',                  'suffix' => 'tmomail.net']),
            Carrier::create(['name' => 'Telus',                     'suffix' => 'msg.telus.com']),
            Carrier::create(['name' => 'Tracfone',                  'suffix' => 'txt.att.net']),
            Carrier::create(['name' => 'Triton',                    'suffix' => 'tms.suncom.com']),
            Carrier::create(['name' => 'Unicel',                    'suffix' => 'utext.com']),
            Carrier::create(['name' => 'US Cellular',               'suffix' => 'email.uscc.net']),
            Carrier::create(['name' => 'US West',                   'suffix' => 'uswestdatamail.com']),
            Carrier::create(['name' => 'Verizon',                   'suffix' => 'vtext.com']),
            Carrier::create(['name' => 'Virgin Mobile',             'suffix' => 'vmobl.com']),
            Carrier::create(['name' => 'Virgin Mobile Canada',      'suffix' => 'vmobile.ca']),
            Carrier::create(['name' => 'West Central Wireless',     'suffix' => 'sms.wcc.net']),
            Carrier::create(['name' => 'Western Wireless',          'suffix' => 'cellularonewest.com']),
            
            //international carriers
            
            Carrier::create(['name' => 'Chennai RPG Cellular',      'suffix' => 'rpgmail.net']),
            Carrier::create(['name' => 'Chennai Skycell / Airtel',  'suffix' => 'airtelchennai.com']),
            Carrier::create(['name' => 'Comviq',                    'suffix' => 'sms.comviq.se']),
            Carrier::create(['name' => 'Delhi Aritel',              'suffix' => 'airtelmail.com']),
            Carrier::create(['name' => 'Delhi Hutch',               'suffix' => 'delhi.hutch.co.in']),
            Carrier::create(['name' => 'DT T-Mobile',               'suffix' => 't-mobile-sms.de']),
            Carrier::create(['name' => 'Dutchtone / Orange-NL',     'suffix' => 'sms.orange.nl']),
            Carrier::create(['name' => 'EMT',                       'suffix' => 'sms.emt.ee']),
            Carrier::create(['name' => 'Escotel',                   'suffix' => 'escotelmobile.com']),
            Carrier::create(['name' => 'German T-Mobile',           'suffix' => 't-mobile-sms.de']),
            Carrier::create(['name' => 'Gujarat Celforce',          'suffix' => 'celforce.com']),
            Carrier::create(['name' => 'JSM Tele-Page',             'suffix' => 'jsmtel.com']),
            Carrier::create(['name' => 'Kerala Escotel',            'suffix' => 'escotelmobile.com']),
            Carrier::create(['name' => 'Kolkata Airtel',            'suffix' => 'airtelkol.com']),
            Carrier::create(['name' => 'Kyivstar',                  'suffix' => 'smsmail.lmt.lv']),
            Carrier::create(['name' => 'Lauttamus Communication',   'suffix' => 'e-page.net']),
            Carrier::create(['name' => 'LMT',                       'suffix' => 'smsmail.lmt.lv']),
            Carrier::create(['name' => 'Maharashtra Idea Cellular', 'suffix' => 'ideacellular.net']),
            Carrier::create(['name' => 'Manitoba Telecom Systems',  'suffix' => 'text.mtsmobility.com']),
            Carrier::create(['name' => 'Meteor',                    'suffix' => 'mymeteor.ie']),
            Carrier::create(['name' => 'MiWorld',                   'suffix' => 'm1.com.sg']),
            Carrier::create(['name' => 'Mobileone',                 'suffix' => 'm1.com.sg']),
            Carrier::create(['name' => 'Mobilfone',                 'suffix' => 'page.mobilfone.com']),
            Carrier::create(['name' => 'Mobility Bermuda',          'suffix' => 'ml.bm']),
            Carrier::create(['name' => 'Mobistar Belgium',          'suffix' => 'mobistar.be']),
            Carrier::create(['name' => 'Mobitel Tanzania',          'suffix' => 'sms.co.tz']),
            Carrier::create(['name' => 'Mobtel Srbija',             'suffix' => 'mobtel.co.yu']),
            Carrier::create(['name' => 'Movistar',                  'suffix' => 'correo.movistar.net']),
            Carrier::create(['name' => 'Netcom',                    'suffix' => 'sms.netcom.no']),
            Carrier::create(['name' => 'Ntelos',                    'suffix' => 'pcs.ntelos.com']),
            Carrier::create(['name' => 'O2',                        'suffix' => 'o2imail.co.uk']),
            Carrier::create(['name' => 'O2 (M-mail)',               'suffix' => 'mmail.co.uk']),
            Carrier::create(['name' => 'One Connect Austria',       'suffix' => 'onemail.at']),
            Carrier::create(['name' => 'Optus Mobile',              'suffix' => 'optusmobile.com.au']),
            Carrier::create(['name' => 'Orange',                    'suffix' => 'orange.net']),
            Carrier::create(['name' => 'Orange Mumbai',             'suffix' => 'orangemail.co.in']),
            Carrier::create(['name' => 'Orange NL / Dutchtone',     'suffix' => 'sms.orange.nl']),
            Carrier::create(['name' => 'Oskar',                     'suffix' => 'mujoskar.cz']),
            Carrier::create(['name' => 'P&T Luxembourg',            'suffix' => 'sms.luxgsm.lu']),
            Carrier::create(['name' => 'Personal Communication',    'suffix' => 'sms@pcom.ru']),
            Carrier::create(['name' => 'Primtel',                   'suffix' => 'sms.primtel.ru']),
            Carrier::create(['name' => 'Safaricom',                 'suffix' => 'safaricomsms.com']),
            Carrier::create(['name' => 'Satelindo GSM',             'suffix' => 'satelindogsm.com']),
            Carrier::create(['name' => 'SCS-900',                   'suffix' => 'scs-900.ru']),
            Carrier::create(['name' => 'SFR France',                'suffix' => 'sfr.fr']),
            Carrier::create(['name' => 'Simple Freedom',            'suffix' => 'text.simplefreedom.net']),
            Carrier::create(['name' => 'Smart Telecom',             'suffix' => 'mysmart.mymobile.ph']),
            Carrier::create(['name' => 'Southern LINC',             'suffix' => 'page.southernlinc.com']),
            Carrier::create(['name' => 'Sunrise Mobile',            'suffix' => 'mysunrise.ch']),
            Carrier::create(['name' => 'Sunrise Mobile',            'suffix' => 'swmsg.com']),
            Carrier::create(['name' => 'Surewest Communications',   'suffix' => 'freesurf.ch']),
            Carrier::create(['name' => 'Swisscom',                  'suffix' => 'bluewin.ch']),
            Carrier::create(['name' => 'T-Mobile Austria',          'suffix' => 'sms.t-mobile.at']),
            Carrier::create(['name' => 'T-Mobile Germany',          'suffix' => 't-d1-sms.de']),
            Carrier::create(['name' => 'T-Mobile UK',               'suffix' => 't-mobile.uk.net']),
            Carrier::create(['name' => 'Tele2 Latvia',              'suffix' => 'sms.tele2.lv']),
            Carrier::create(['name' => 'Telefonica Movistar',       'suffix' => 'movistar.net']),
            Carrier::create(['name' => 'Telenor',                   'suffix' => 'mobilpost.no']),
            Carrier::create(['name' => 'Teletouch',                 'suffix' => 'pageme.teletouch.com']),
            Carrier::create(['name' => 'Telia Denmark',             'suffix' => 'gsm1800.telia.dk']),
            Carrier::create(['name' => 'TIM',                       'suffix' => 'timnet.com']),
            Carrier::create(['name' => 'TSR Wireless',              'suffix' => 'alphame.com']),
            Carrier::create(['name' => 'TSR Wireless',              'suffix' => 'beep.com']),
            Carrier::create(['name' => 'UMC',                       'suffix' => 'sms.umc.com.ua']),
            Carrier::create(['name' => 'Uraltel',                   'suffix' => 'sms.uraltel.ru']),
            Carrier::create(['name' => 'Uttar Pradesh Escotel',     'suffix' => 'escotelmobile.com']),
            Carrier::create(['name' => 'Vessotel',                  'suffix' => 'pager.irkutsk.ru']),
            Carrier::create(['name' => 'Vodafone Italy',            'suffix' => 'sms.vodafone.it']),
            Carrier::create(['name' => 'Vodafone Japan',            'suffix' => 'c.vodafone.ne.jp']),
            Carrier::create(['name' => 'Vodafone Japan',            'suffix' => 'h.vodafone.ne.jp']),
            Carrier::create(['name' => 'Vodafone Japan',            'suffix' => 't.vodafone.ne.jp']),
            Carrier::create(['name' => 'Vodafone UK',               'suffix' => 'vodafone.net']),
            Carrier::create(['name' => 'Wyndtell',                  'suffix' => 'wyndtell.com']),
            
            
            
            Carrier::create(['name' => 'Advantage Communications',  'suffix' => 'advantagepaging.com']),
            Carrier::create(['name' => 'Airtouch Pagers',           'suffix' => 'myairmail.com']),
            Carrier::create(['name' => 'Airtouch Pagers',           'suffix' => 'alphapage.airtouch.com']),
            Carrier::create(['name' => 'Airtouch Pagers',           'suffix' => 'airtouch.net']),
            Carrier::create(['name' => 'Airtouch Pagers',           'suffix' => 'airtouchpaging.com']),
            Carrier::create(['name' => 'AlphNow',                   'suffix' => 'alphanow.net']),
            Carrier::create(['name' => 'Alltel',                    'suffix' => 'alltelmessage.com']),
            Carrier::create(['name' => 'Ameritech Paging',          'suffix' => 'paging.acswireless.com']),
            Carrier::create(['name' => 'Ameritech Paging',          'suffix' => 'pageapi.com']),
            Carrier::create(['name' => 'Ameritech Clearpath',       'suffix' => 'clearpath.acswireless.com']),
            Carrier::create(['name' => 'Andhra Pradesh Airtel',     'suffix' => 'airtelap.com']),
            Carrier::create(['name' => 'WebLink Wiereless',         'suffix' => 'airmessage.net']),
            Carrier::create(['name' => 'WebLink Wiereless',         'suffix' => 'pagemart.net']),
            Carrier::create(['name' => 'Arch Pagers (PageNet)',     'suffix' => 'archwireless.net']),
            Carrier::create(['name' => 'Arch Pagers (PageNet)',     'suffix' => 'epage.arch.com']),
            Carrier::create(['name' => 'Cellular One West',         'suffix' => 'mycellone.com'])
        ];
    }
}
/*
AT&T Pocketnet PCS

<10-digit-number>@dpcs.mobile.att.net

B
Beepwear

<10-digit-number>@beepwear.net

BeeLine GSM

<10-digit-number>@sms.beemail.ru

Bell Atlantic

<10-digit-number>@message.bam.com

Bell Canada

<10-digit-number>@txt.bellmobility.ca

<10-digit-number>@bellmobility.ca

Bell Mobility

<10-digit-number>@txt.bellmobility.ca

Bell South (Blackberry)

<10-digit-number>@bellsouthtips.com

Bell South

<10-digit-number>@sms.bellsouth.com

<10-digit-number>@wireless.bellsouth.com

<10-digit-number>@blsdcs.net

<10-digit-number>@bellsouth.cl

Bell South Mobility

<10-digit-number>@blsdcs.net

Bluegrass Cellular

<10-digit-number>@sms.bluecell.com


C
Cellular One East Coast

<10-digit-number>@phone.cellone.net

Cellular One South West

<10-digit-number>@swmsg.com

Cellular One PCS

<10-digit-number>@paging.cellone-sf.com

Cellular One

<10-digit-number>@mobile.celloneusa.com

<10-digit-number>@cellularone.txtmsg.com

<10-digit-number>@cellularone.textmsg.com

<10-digit-number>@cell1.textmsg.com

<10-digit-number>@message.cellone-sf.com

<10-digit-number>@sbcemail.com

Cellular South

<10-digit-number>@csouth1.com

Central Vermont Communications

<10-digit-number>@cvcpaging.com

CenturyTel

<10-digit-number>@messaging.centurytel.net

Chennai RPG Cellular

<10-digit-number>@rpgmail.net

Chennai Skycell / Airtel

<10-digit-number>@airtelchennai.com

Cincinnati Bell

<10-digit-number>@mobile.att.net

Cingular Wireless

<10-digit-number>@mycingular.textmsg.com

<10-digit-number>@mobile.mycingular.com

<10-digit-number>@mobile.mycingular.net

Claro Wireless

<10-digit-number>@vtexto

Clearnet

<10-digit-number>@msg.clearnet.com



Communication Specialists

<pin-number>@pageme.comspeco.net

Communication Specialist Companies

<pin-number>@pager.comspeco.com

Comviq

<10-digit-number>@sms.comviq.se

Cook Paging

<10-digit-number>@cookmail.com

Corr Wireless Communications

<10-digit-number>@corrwireless.net

D
Delhi Aritel

<10-digit-number>@airtelmail.com

Delhi Hutch

<10-digit-number>@delhi.hutch.co.in

Digi-Page / Page Kansas

<10-digit-number>@page.hit.net

Dobson Cellular Systems

<10-digit-number>@mobile.dobson.net

Dobson-Alex Wireless / Dobson-Cellular One

<10-digit-number>@mobile.cellularone.com

DT T-Mobile

<10-digit-number>@t-mobile-sms.de

Dutchtone / Orange-NL

<10-digit-number>@sms.orange.nl

E
Edge Wireless

<10-digit-number>@sms.edgewireless.com

EMT

<10-digit-number>@sms.emt.ee

Emtel

<7-digit-number>@emtelworld.net

Escotel

<10-digit-number>@escotelmobile.com

F
Fido

<10-digit-number>@fido.ca

G
Galaxy Corporation

<10-digit-number>.epage@sendabeep.net

GCS Paging

<10-digit-number>@webpager.us

Google Project Fi

<10-digit-number>@msg.fi.google.com

Golden Telecom

<10-digit-number>@sms.goldentele.com

GrayLink / Porta-Phone

<10-digit-number>@epage.porta-phone.com

GTE

<10-digit-number>@airmessage.net

<10-digit-number>@gte.pagegate.net

<10-digit-number>@messagealert.com

Gujarat Celforce

<10-digit-number>@celforce.com

H
Houston Cellular

<10-digit-number>@text.houstoncellular.net

I
Idea Cellular

<10-digit-number>@ideacellular.net

Infopage Systems

<pin-number>@page.infopagesystems.com

Inland Cellular Telephone

<10-digit-number>@inlandlink.com

J
JSM Tele-Page

<pin-number>@jsmtel.com

K
Kerala Escotel

<10-digit-number>@escotelmobile.com

Kolkata Airtel

<10-digit-number>@airtelkol.com

Kyivstar

<10-digit-number>@smsmail.lmt.lv

L
Lauttamus Communication

<10-digit-number>@e-page.net

LMT

<10-digit-number>@smsmail.lmt.lv

Maharashtra Idea Cellular

<10-digit-number>@ideacellular.net

Manitoba Telecom Systems

<10-digit-number>@text.mtsmobility.com

MCI Phone

<10-digit-number>@mci.com

MCI

<10-digit-number>@pagemci.com

Meteor

<10-digit-number>@mymeteor.ie

<10-digit-number>@sms.mymeteor.ie

Metrocall

<10-digit-number>@page.metrocall.com

Metrocall 2-way

<10-digit-number>@my2way.com

Metro PCS

<10-digit-number>@mymetropcs.com

<10-digit-number>@metropcs.sms.us

Microcell

<10-digit-number>@fido.ca

Midwest Wireless

<10-digit-number>@clearlydigital.com



Mobilecom PA

<10-digit-number>@page.mobilcom.net

Mobilecomm

<10-digit-number>@mobilecomm.net


Mobilfone

<10-digit-number>@page.mobilfone.com

Mobility Bermuda

<10-digit-number>@ml.bm

Mobistar Belgium

<10-digit-number>@mobistar.be

Mobitel Tanzania

<10-digit-number>@sms.co.tz

Mobtel Srbija

<10-digit-number>@mobtel.co.yu

Morris Wireless

<10-digit-number>@beepone.net

Motient

<10-digit-number>@isp.com

Movistar

<10-digit-number>@correo.movistar.net

Mumbai Orange

<10-digit-number>@orangemail.co.in

N
NBTel

<10-digit-number>@wirefree.informe.ca

Netcom

<10-digit-number>@sms.netcom.no

Nextel

<10-digit-number>@messaging.nextel.com

<10-digit-number>@page.nextel.com

<10-digit-number>@nextel.com.br

NPI Wireless

<10-digit-number>@npiwireless.com

Ntelos

<10-digit-number>@pcs.ntelos.com

O
O2

<name>@o2.co.uk

O2 (M-mail)

<10-digit-number>@mmail.co.uk

Omnipoint

<10-digit-number>@omnipoint.com

<10-digit-number>@omnipointpcs.com

One Connect Austria

<10-digit-number>@onemail.at

OnlineBeep

<10-digit-number>@onlinebeep.net

Optus Mobile

<10-digit-number>@optusmobile.com.au

Orange

<10-digit-number>@orange.net

Orange Mumbai

<10-digit-number>@orangemail.co.in

Orange – NL / Dutchtone

<10-digit-number>@sms.orange.nl

Oskar

<10-digit-number>@mujoskar.cz

P
P&T Luxembourg

<10-digit-number>@sms.luxgsm.lu

Pacific Bell

<10-digit-number>@pacbellpcs.net

PageMart

<pin-number>@pagemart.net

PageMart Advanced /2way

<10-digit-number>@airmessage.net

PageMart Canada

<10-digit-number>@pmcl.net

PageNet Canada

<10-digit-number>@pagegate.pagenet.ca

PageOne NorthWest

<10-digit-number>@page1nw.com

PCS One

<10-digit-number>@pcsone.net

Personal Communication

sms@pcom.ru (<10-digit-number> in subject line)

Pioneer / Enid Cellular

<10-digit-number>@msg.pioneerenidcellular.com

PlusGSM

<10-digit-number>@text.plusgsm.pl

Powertel

<10-digit-number>@voicestream.net

Price Communications

<10-digit-number>@mobilecell1se.com

Primco

<10-digit-number>@primeco@textmsg.com

Primtel

<10-digit-number>@sms.primtel.ru

ProPage

<7-digit-number>@page.propage.net

Public Service Cellular

<10-digit-number>@sms.pscel.com

Q
Qualcomm

<name>@pager.qualcomm.com

Qwest

<10-digit-number>@qwestmp.com

R
RAM Page

<10-digit-number>@ram-page.com

Rogers

<10-digit-number>@pcs.rogers.com

<10-digit-number>@sms.rogers.com

S
Safaricom

<10-digit-number>@safaricomsms.com

Satelindo GSM

<10-digit-number>@satelindogsm.com

Satellink

<10-digit-number>.pageme@satellink.net

SBC Ameritech Paging

<10-digit-number>@paging.acswireless.com

SCS-900

<10-digit-number>@scs-900.ru

SFR France

<10-digit-number>@sfr.fr

Skytel Pagers

<pin-number>@skytel.com

<10-digit-number>@email.skytel.com

Simple Freedom

<10-digit-number>@text.simplefreedom.net

Smart Telecom

<10-digit-number>@mysmart.mymobile.ph

Southern LINC

<10-digit-number>@page.southernlinc.com

Southwestern Bell

<10-digit-number>@email.swbw.com

Sprint

<10-digit-number>@sprintpaging.com

Sprint PCS

<10-digit-number>@messaging.sprintpcs.com

ST Paging

<pin-number>@page.stpaging.com

SunCom

<10-digit-number>@tms.suncom.com

<10-digit-number>@suncom1.com

Sunrise Mobile

<10-digit-number>@mysunrise.ch

<10-digit-number>@freesurf.ch

Surewest Communications

<10-digit-number>@mobile.surewest.com

Swisscom

<10-digit-number>@bluewin.ch

T
The Indiana Paging Co

<last-4-digits>@pager.tdspager.com

T-Mobile

<10-digit-number>@tmomail.net

<10-digit-number>@voicestream.net

T-Mobile Austria

<10-digit-number>@sms.t-mobile.at

T-Mobile Germany

<10-digit-number>@t-d1-sms.de

T-Mobile UK

<10-digit-number>@t-mobile.uk.net

Tele2 Latvia

<10-digit-number>@sms.tele2.lv

Telefonica Movistar

<10-digit-number>@movistar.net


Telia Denmark

<10-digit-number>@gsm1800.telia.dk







Uraltel

<10-digit-number>@sms.uraltel.ru

US Cellular

<10-digit-number>@email.uscc.net

US Cellular

<10-digit-number>@uscc.textmsg.com

US West

<10-digit-number>@uswestdatamail.com

Uttar Pradesh Escotel

<10-digit-number>@escotelmobile.com

V
Verizon Pagers

<10-digit-number>@myairmail.com

Verizon PCS

<10-digit-number>@vtext.com

<10-digit-number>@myvzw.com

Vessotel

<10-digit-number>@pager.irkutsk.ru




Vodafone Spain

<10-digit-number>@vodafone.es

VoiceStream / T-Mobile

<10-digit-number>@voicestream.net
*/