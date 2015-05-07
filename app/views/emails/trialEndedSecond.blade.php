@extends('emails.meta.meta')
  @section('emailContent')
    <p>Hi @if(isset($user->name))
      {{$user->name}}
    @else
      there,
    @endif</p>

    <p>Did you have enough time to evaluate ChartMogul? Please let us know if you'd like us to reactivate your Fruit Analytics account for another week.</p>
    
    <p>We would love to hear your feedback on why you decided against purchasing Fruit Analytics at this time...is there something missing that you needed?</p>

  @stop
