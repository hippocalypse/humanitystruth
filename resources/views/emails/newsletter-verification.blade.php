@extends('emails.layouts.master')

@section('subject')
    Confirm your HumanitysTruth newsletter subscription!
@stop

@section('body')
    Thanks for joining our mailing list! With it, you'll gain access to the latest significant intelligence and technology leaks.
    Please confirm your subscription request by clicking the link below:
    {{url('/newsletter/subscribe/'.$authenticate_token)}}
    
    If you did not request a subscription to HumanitysTruth's newsletter, you do not need to do anything.
@stop