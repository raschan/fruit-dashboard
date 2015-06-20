<?php

class ChartHelper {

	public static function wizard($step = NULL){

		switch ($step) {

			case 'init':
				return View::make('connect.connect-graph')->with(array(
					'step' => 'select-source',
					'isBackgroundOn' => Auth::user()->isBackgroundOn,
					'dailyBackgroundURL' => Auth::user()->dailyBackgroundURL(),				
				));
				break;

			case 'source-selected':
				switch (Input::get('source')) {
					case 'google-spreadsheet-line-cell':
						return Redirect::to('connect/new/googlespreadsheet/set-type')->with(array(
							'type' => Input::get('source')
						));
						break;
					case 'google-spreadsheet-line-column':
						return Redirect::to('connect/new/googlespreadsheet/set-type')->with(array(
							'type' => Input::get('source')
						));
						break;
					default:
						return Redirect::route('connect.connect')
							->with('error', 'Something went wrong.');
						break;
				}		
			break; # /source-selected

		} # / switch ($step)
	} # / function wizard
} # / class TextHelper