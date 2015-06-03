  <li class="dashboard-widget well" data-row="{{ $position['row'] }}" data-col="{{ $position['col'] }}" data-sizex="{{ $position['x'] }}" data-sizey="{{ $position['y'] }}"> 
    <a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
    <iframe width="100%" height="100%" frameborder="0" src="{{ $iframeUrl }}"></iframe>
  </li>
