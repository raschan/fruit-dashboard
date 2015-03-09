<?php

class EventSeeder extends Seeder
{

    public function run()
    {
        DB::table('event')->delete();    

        $currentDay = time();
        $user = User::find(1);
        // days generated before the current date
        $generatedDay = $currentDay - 370*24*60*60;

        // generating data for ~2 years
        for ($i = 0; $i < 750; $i++) { 
            // timestamp of the current day
            $dailyTimeStamp = $generatedDay + $i*24*60*60;
            $date = date('Y-m-d', $dailyTimeStamp);
            $monthStats = monthlyStats($dailyTimeStamp);
            $eventTimes = generateEventTimes($monthStats, $dailyTimeStamp);

            foreach ($eventTimes as $event){
            $temparray = getEventType($monthStats, $event);
                DB::table('event')->insert(
                    array(
                        'user' => 1,
                        'created' => $temparray['created'],
                        'eventID' => $temparray['id'],
                        'type' => $temparray['type'],
                        'object' => $temparray['object'],
                        'provider' => 'stripe',
                        'previousAttributes' => $temparray['previousAttributes'],
                        'date' => $date
                    )
                );
            }
            // set time to last timestamp +1 
            $event++;
            // calculate all
            Calculator::calculateMetrics($user, $event);
        }
        // returns a random event type with the corresponding data array ready for seeding
        public function getEventType($monthStats, $eventTime){
            $randomNumber = rand(1,100);
            if ( $randomNumber > 0 && $randomNumber =< $monthStats['subscriptions']){
                $array['type'] = 'customer.subsription.created';
                $array['id'] = generateRandomString();
                $array['created'] = $eventTime;
                $temparray = fillObject('subscriptions');
                $array['object'] = $temparray['json']
            }
            elseif ( $randomNumber > $monthStats['subscriptions'] && $randomNumber =< $monthStats['cancels']){
                $array['type'] = 'customer.subscription.deleted';
                $array['id'] = generateRandomString();
                $array['created'] = $eventTime;
                $temparray = fillObject('cancels');
                $array['object'] = $temparray['json']
            }
            elseif ( $randomNumber >= $monthStats['cancels'] && $randomNumber =< $monthStats['updates']){
                $array['type'] = 'customer.subscription.updated';
                $array['id'] = generateRandomString();
                $array['created'] = $eventTime;
                $temparray = fillObject('updates');
                $array['object'] = $temparray['json'];
                $array['previousAttributes'] = $temparray['previous'];
            }
            return $array;
        }

        // fills the event object with the corresponding data
        public function fillObject($type){
            $name = generateRandomString(8);
            $plan = getRandomPlan();
            $object[];
            switch ($type){
                case 'subscriptions':
                // jsonencode
                $object['json'] = json_encode("plan": {
                    "interval": "month",
                    "name": $plan['name'],
                    "amount": $plan['amount'],
                });
                break;
                case 'cancels':
                // jsonencode
                $object['json'] = json_encode("plan": {
                    "interval": "month",
                    "name": $plan['name'],
                    "amount": $plan['amount'],
                });
                break;                
                case 'updates':
                // jsonencode
                $object['json'] = json_encode("plan": {
                    "interval": "month",
                    "name": $plan['name'],
                    "amount": $plan['amount'],
                });
                // i need a previous attributes json
                $object['previous'] = json_encode("previous_attributes": {
                    "interval": "month",
                    "name": $plan['nameChange'],
                    "amount": $plan['amountChange'],
                });
                break;
                case 'default':
                break;
            }
            return $object;
        }

        // returns an array of timestamps
        public function generateEventTimes ($monthStats, $dailyTimeStamp){
            $min = $dailyTimeStamp;
            $max = $dailyTimeStamp + 24*60*58;

            $modulus = ($max - $min) / $monthStats['eventNumber'];

            $array[];
            for ($i=0;$i<$monthStats['eventNumber'];$i++){
                array_push($array, $dailyTimeStamp + ($modulus * $i));
            }
            return $array;
        }

        // gives the base number of events on a day and a probability number for event type randomizing
        public function monthlyStats($dailyTimeStamp){
            $month_name = getMonth($dailyTimeStamp);
            $array[];
            switch ($month_name){
                case 'Jan':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 100;
                    $array['cancels'] = 0;
                    $array['updates'] = 0;
                    break;
                case 'Feb':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 80;
                    $array['cancels'] = 5;
                    $array['updates'] = 15;
                    break;
                case 'Mar':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 70;
                    $array['cancels'] = 10;
                    $array['updates'] = 20;
                    break;
                case 'Apr':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 65;
                    $array['cancels'] = 10;
                    $array['updates'] = 25;
                    break;
                case 'May':
                    $array['eventNumber'] = 25;
                    $array['subscriptions'] = 70;
                    $array['cancels'] = 15;
                    $array['updates'] = 15;
                    break;
                case 'Jun':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 80;
                    $array['cancels'] = 10;
                    $array['updates'] = 10;
                    break;
                case 'Jul':
                    $array['eventNumber'] = 12;
                    $array['subscriptions'] = 60;
                    $array['cancels'] = 25;
                    $array['updates'] = 15;
                    break;
                case 'Aug':
                    $array['eventNumber'] = 10;
                    $array['subscriptions'] = 50;
                    $array['cancels'] = 20;
                    $array['updates'] = 30;
                    break;
                case 'Sep':
                    $array['eventNumber'] = 12;
                    $array['subscriptions'] = 60;
                    $array['cancels'] = 15;
                    $array['updates'] = 25;
                    break;
                case 'Oct':
                    $array['eventNumber'] = 15;
                    $array['subscriptions'] = 65;
                    $array['cancels'] = 15;
                    $array['updates'] = 20;
                    break;
                case 'Nov':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 70;
                    $array['cancels'] = 15;
                    $array['updates'] = 15;
                    break;
                case 'Dec':
                    $array['eventNumber'] = 30;
                    $array['subscriptions'] = 80;
                    $array['cancels'] = 10;
                    $array['updates'] = 10;
                    break; 
                case 'default':
                    $array['eventNumber'] = 20;
                    $array['subscriptions'] = 85;
                    $array['cancels'] = 5;
                    $array['updates'] = 10;
                    break;
                }
            return $array;               
        }

        public function getMonth($timeStamp){
            $months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

            $date = getdate();
            $month = $date['mon'];
            return $months[$month];
        }

        public function generateRandomString($length = 16) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public function getRandomPlan(){
            $plan[];
            // plan
            $random = rand(1,3);
            // plan change from
            $random2 = rand(1,3);

            switch ($random) {
                case '1':
                    $plan['name'] = 'ini'
                    $plan['amount'] = 19;
                    break;
                case '2':
                    $plan['name'] = 'mini'
                    $plan['amount'] = 29;
                    break;
                case '3':
                    $plan['name'] = 'mino'
                    $plan['amount'] = 49;
                    break;
                default:
                    break;
            }

            switch ($random2) {
                case '1':
                    $plan['nameChange'] = 'ini'
                    $plan['amountChange'] = 19;
                    break;
                case '2':
                    $plan['nameChange'] = 'mini'
                    $plan['amountChange'] = 29;
                    break;
                case '3':
                    $plan['nameChange'] = 'mino'
                    $plan['amountChange'] = 49;
                    break;
                default:
                    break;
            }

            return $plan;
        }
    }
}