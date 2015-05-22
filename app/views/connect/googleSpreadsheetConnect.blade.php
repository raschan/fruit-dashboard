@extends('meta.base-user')

  @section('pageContent')
    
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->
      @parent

      <h1>Select spreadsheet</h1>

      {{ Form::open(
        array(
          'url'=>'connect/googlespreadsheet/2',
          'method' => 'post',
        )
      ) }}

        <select name="spreadsheet">
        @foreach ($spreadsheetFeed as $entry)
          <option value="{{ $entry->getId() }}">{{ $entry->getTitle() }}</option>
        @endforeach
        </select>

        {{ Form::submit(
          'Next >')
        }}

      {{ Form::close() }}

    </div> <!-- / #content-wrapper -->

  @stop
