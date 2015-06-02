<li class="dashboard-widget well" data-row="1" data-col="1" data-sizex="10" data-sizey="10"> 
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
	<iframe width="100%" height="100%" frameborder="0" src="{{ $iframeUrl }}"></iframe>
</li>