@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi @if(isset($user->name))
      {{$user->name}}
    @else
      there,
    @endif</p>

    <p>Your trial of Fruit Analytics ... is almost over.</p> 

    <p>Please update your payment information to keep your account active by going {{ HTML::secureLink('/plans','here') }} within the next 3 days or your account will be suspended.</p>  

    <p>Either way, thanks for trying Fruit Analytics!</p>
  @stop
