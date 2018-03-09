@extends('emails.master')

@section('subject')Welcome to HumanitysTruth!
@stop

@section('body')
    Please confirm your email by clicking the link below:
    {{url('/verifyemail/'.$email_token)}}
@stop