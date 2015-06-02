<li class="dashboard-widget well" data-row="1" data-col="1" data-sizex="2" data-sizey="2"> 
	<a href="{{ URL::route('connect.deletewidget', $id) }}"><span class="fa fa-times pull-right widget-close"></span></a>
	<ul>
    @foreach ($list as $value)
    	<li class="list-group-item no-border-hr padding-xs-hr">
        	{{ $value }}
    	</li>
    @endforeach
  	</ul>
</li>
