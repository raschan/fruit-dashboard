<?php

class Metric extends Eloquent
{
	protected $guarded = array();

	public function formatMetrics()
	{
		// get currently calculated metrics
		$currentMetrics = Calculator::currentMetrics();

		$this->date = Carbon::createFromFormat('Y-m-d', $this->date)->format('Y-m-d, l');
		// go through them
		foreach ($currentMetrics as $statID => $statName) {
			switch ($statID) {

				// money formats fall through
				case 'mrr':
				case 'arr':
				case 'arpu':
					// divide the value by 100
					$this->$statID /= 100;

					// format it into money
					setlocale(LC_MONETARY, 'en_US');
					$this->$statID = money_format('%n',$this->$statID);
					break;

				// percent formats fall through
				case 'uc':
					$this->$statID = $this->$statID.'%';
					break;

				// pieces formats fall through
				case 'cancellations':
				case 'au':
					break;

				default:
					break;
			}
		}
	}
}

?>