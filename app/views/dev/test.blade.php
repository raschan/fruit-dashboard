@extends('meta.base-user')
		@section('pageContent')
	<div id='content-wrapper'>
		@include('dev.test2')
		<p>include other page here</p>
			<p>test1 content</p>
	</div>
		@append


	@section('pageScripts')
		<p> this is section from 'pageScripts' in test1</p>
	@append
