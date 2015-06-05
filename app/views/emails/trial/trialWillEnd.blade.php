@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi there @if(isset($user->name))
      {{$user->name}}
    @endif,</p>

    <p>Your trial of Fruit Analytics is almost over.</p> 

    <p>You can upgrade your account ({{ HTML::secureLink('/plans','here') }}) within the next 3 days to keep it alive, or it will be suspended.</p>  

    <p>Either way, thanks for trying Fruit Analytics, we hope to see you really soon!</p>
  @stop
