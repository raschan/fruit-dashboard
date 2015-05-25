@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
  <div class="page-header text-center">
    <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Connect a service</h1>
  </div> <!-- / .page-header -->
  @parent

  <div class="col-md-10 col-md-offset-1">
    <div class="row">
     <div class="col-sm-6 col-md-offset-3 connect-form">
      <div class="panel-body bordered sameHeight">

        @if (!isset($step))

          <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select spreadsheet</h4>

          {{ 
            Form::open(
              array(
                'url'=>'connect/googlespreadsheet/2',
                'method' => 'post',
              )
            ) 
          }}

          <div class="col-sm-8">
            <select name="spreadsheetId" class="form-control">
              @foreach ($spreadsheetFeed as $entry)
              <option value="{{ basename($entry->getId()) }}">{{ $entry->getTitle() }}</option>
              @endforeach
            </select>
          </div>

          {{ 
            Form::submit('Next >', array(
              'class' => 'btn btn-flat btn-info btn-sm pull-right'
            )) 
          }}

        {{ Form::close() }}
      
        @endif

      @if (isset($step) && ($step == 2))

        <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select worksheet</h4>

      {{ Form::open(
      array(
      'url'=>'connect/googlespreadsheet/3',
      'method' => 'post',
      )
      ) }}

      <div class="col-sm-8">
        <select name="worksheetName" class="form-control">
          @foreach ($worksheetFeed as $entry)
          <option value="{{ $entry->getTitle() }}">{{ $entry->getTitle() }}</option>
          @endforeach
        </select>
      </div>

    {{ 
      Form::submit('Next >', array(
        'class' => 'btn btn-flat btn-info btn-sm pull-right'
      )) 
    }}

    {{ Form::close() }}
    @endif

    @if (isset($step) && ($step == 3))
        <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select input type</h4>

    {{ Form::open(
    array(
    'url'=>'connect/googlespreadsheet/4',
    'method' => 'post',
    )
    ) }}

    <input type="radio" name="type" value="google-spreadsheet-linear"/> Single cell (the data will be at the cell A2)<br/>
    <input type="radio" name="type" value="google-spreadsheet-table"/> Single column (date is in column A, data is in column B)

    {{ 
      Form::submit('Save', array(
        'class' => 'btn btn-flat btn-info btn-sm pull-right'
      )) 
    }}

  {{ Form::close() }}
  @endif

        </div>
      </div>
    </div>
  </div>
</div> <!-- / #content-wrapper -->

@stop
