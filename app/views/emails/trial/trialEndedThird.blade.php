@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi there @if(isset($user->name))
      {{$user->name}}
    @endif,</p>
    <p>We’re a bit afraid we have lost you, which would be a shame.</p>

    <p>Could you give us a little feedback on Fruit Analytics? What did you miss from the tool?</p>

    <p>If you’d like to upgrade to one of our plans, just didn’t get our last mails, <br/>
    you can still do it ({{ HTML::secureLink('/plans','here') }})</p>
    
  @stop
