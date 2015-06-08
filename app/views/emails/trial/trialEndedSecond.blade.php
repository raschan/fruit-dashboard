@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi there @if(isset($user->name))
      {{$user->name}}
    @endif,</p>

    <p>Did you have enough time to evaluate Fruit Analytics?  Please let us know if you'd like us to reactivate your Fruit Analytics account for another week.</p>
    
    <p>We would love to hear your feedback on why you decided not to purchase Fruit Analytics this time... Is there something missing that you needed?</p>

  @stop
