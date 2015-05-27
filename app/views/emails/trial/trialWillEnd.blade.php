@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi @if(isset($user->name))
      {{$user->name}}
    @else
      there,
    @endif</p>

    <p>Your trial of Fruit Analytics is almost over.</p> 

    <p>Please choose from one of our plans to keep your account active ({{ HTML::secureLink('/plans','click here') }}) within the next 3 days or your account will be suspended.</p>  

    <p>Either way, thanks for trying Fruit Analytics!</p>
  @stop
