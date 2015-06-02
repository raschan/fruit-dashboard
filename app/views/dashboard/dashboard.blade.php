@extends('meta.base-user')

  @section('pageTitle')
    Dashboard
  @stop

  @section('pageStylesheet')
  @stop

  @section('pageContent')
    <div id='content-wrapper'>

      @for ($i = 0; $i < count($allFunctions); $i++)

        @include('dashboard.widget', ['widget_data' => $allFunctions[$i]])

      @endfor

    </div>
  @stop

  @section('pageScripts')
  @stop

