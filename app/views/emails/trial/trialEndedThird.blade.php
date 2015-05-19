@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi @if(isset($user->name))
      {{$user->name}}
    @else
      there,
    @endif</p>

    
  @stop
