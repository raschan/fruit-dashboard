@extends('meta.base-user')

  @section('pageContent')
    
    <div id="content-wrapper">
      <div class="page-header text-center">
        <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
      </div> <!-- / .page-header -->
      @parent

      @if (!isset($step))
        <h1>Select spreadsheet</h1>

        {{ Form::open(
          array(
            'url'=>'connect/googlespreadsheet/2',
            'method' => 'post',
          )
        ) }}

          <select name="spreadsheetId">
          @foreach ($spreadsheetFeed as $entry)
            <option value="{{ basename($entry->getId()) }}">{{ $entry->getTitle() }}</option>
          @endforeach
          </select>

          {{ Form::submit(
            'Next >')
          }}

        {{ Form::close() }}
      @endif

      @if (isset($step) && ($step == 2))
        <h1>Select worksheet</h1>

        {{ Form::open(
          array(
            'url'=>'connect/googlespreadsheet/3',
            'method' => 'post',
          )
        ) }}

          <select name="worksheetName">
          @foreach ($worksheetFeed as $entry)
            <option value="{{ $entry->getTitle() }}">{{ $entry->getTitle() }}</option>
          @endforeach
          </select>

          {{ Form::submit(
            'Next >')
          }}

        {{ Form::close() }}
      @endif

    </div> <!-- / #content-wrapper -->

  @stop
