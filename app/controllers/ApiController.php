<?php


/*
|--------------------------------------------------------------------------
| ApiController: Handles the API
|--------------------------------------------------------------------------
*/
class ApiController extends BaseController
{
	/*
	|===================================================
	| <POST> | saveApiData: saves data from external API calls
	|===================================================
	*/
	public function saveApiData($apiVersion = NULL, $apiKey = NULL)
	{

		$authArray = json_decode(base64_decode($apiKey), true);
		if (!isset($authArray['wid'])) {
			Log::info('API authArray decoding failed');
			return;
		}
		$widgetId = $authArray['wid'];

		$inputArray = Input::all();

		if (!isset($inputArray['data'])) {
			Log::info('API inputArray not valid');
			return;
		}
        $time = time();
		foreach ($inputArray['data'] as $dataArray) {
	        $data = new Data;
	        $data->widget_id = $widgetId;
	        $data->data_object = json_encode(array(
	        	'key'	=> $dataArray['key'],
	        	'value' => $dataArray['value']
	        ));
	        $data->date = date("Y-m-d", $time);
	        $data->timestamp = date('Y-m-d H:i:s', $time);
	        $data->save();
		}
	}
}
