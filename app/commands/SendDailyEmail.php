<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendDailyEmail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'metrics:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends email to all the users with their previous days metrics.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// get all the users
		$users = User::all();
		
		$previousDayDate = Carbon::yesterday()->toDateString();
		// currently calculated metrics
		$currentMetrics = Calculator::currentMetrics();
		// for each user send email with their metrics

		$dailyEmailSent = 0;
		$weeklyEmailSent = 0;
		foreach ($users as $user) {
			// check if user finished the connect process
			if ($user->isConnected())
			{
				switch ($user->summaryEmailFrequency) {

					case 'none': // no summary email
						break;

					case 'daily': // default behavior, send yesterday's data

						// get the user's metrics
						$metrics = Metric::where('user', $user->id)	
										->where('date', $previousDayDate)
										->first();

						if ($metrics)
						{
							// format metrics to presentable data
							$metrics->formatMetrics();
							$data = array(
								'metrics' => $metrics,
								'currentMetrics' => $currentMetrics
								);

							// login the user (necessary to get the email address)	
							Auth::login($user);


							// send the email to the user
							Mail::send('emails.summaryDaily', $data, function($message)
							{
								// get the currently logged in user
								$user = Auth::user();
								$message->to($user->email /*, name of the user*/)
										->subject('Daily summary');
							});
							// logout the user
							Auth::logout();
							$dailyEmailSent++;
						}
						break;

					case 'weekly': // send a weekly summary to the user with their numbers
						// check if today is monday (we send weekly emails on monday)
						/* improvment idea
							change this if to switch-case with days
							for user controlled daily send
						*/
						if(Carbon::now()->dayOfWeek == Carbon::MONDAY)
						{
							// get the user's metrics
							$metrics = Metric::where('user', $user->id)	
											->where('date','<=', $previousDayDate)
											->orderBy('date','desc')
											->take(7)
											->get();

							// format metrics to presentable data
							$weeklyMetrics = array();
							foreach ($metrics as $metric) {
								$metric->formatMetrics();
								$weeklyMetrics[$metric->date] = $metric;
							}
							$data = array(
								'metrics' => $weeklyMetrics,
								'currentMetrics' => $currentMetrics
								);
							// login the user (necessary to get the email address)	
							Auth::login($user);


							// send the email to the user
							Mail::send('emails.summaryWeekly', $data, function($message)
							{
								// get the currently logged in user
								$user = Auth::user();
								$message->to($user->email /*, name of the user*/)
										->subject('Weekly summary');
							});
							// logout the user
							Auth::logout();
							$weeklyEmailSent++;
						}
						break;
				} // /switch
			} // /isConnected
		} // /foreach
		Log::info($dailyEmailSent.' daily summary emails sent out of '.count($users).' users');
		Log::info($weeklyEmailSent.' daily summary emails sent out of '.count($users).' users');
		Log::info('Total of '. $dailyEmailSent + $weeklyEmailSent .' emails sent');
	}
}
