@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi @if(isset($user->name))
      {{$user->name}}
    @else
      there,
    @endif</p>

    <p>Your trial ended.</p>

    <p>Your account has been suspended, and no longer update with new data.</p>
    
    <p>Checkout one of our plans {{ HTML::secureLink('/plans','here') }} to continue using Fruit Analytics</p>
    

  @stop
