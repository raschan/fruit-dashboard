<?php

class Metric extends Eloquent
{
	

	// first time calculator - called once per user
	// can be a long running method
	public function calculateMetricsOnConnect() {
		// request events
		// request plans and subscription infos (alternativly, customers)
		// calculate today's mrr and au
		// reverse calculate from events
			// save daily cancellations

		// calculate arr, arpu, monthly cancellations, uc  
	}

	// showMetric methods

}

?>