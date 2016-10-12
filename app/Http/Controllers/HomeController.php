<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\User;
use App\Jobs\PushNotification;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function save_endpoint(Request $request)
    {
        // $user = User::find(1);
        // $user->endpoint = $request->endpoint;
        // $user->save();
    }

    public function browser_pn()
    {
        return json_encode([
            'notification' => [
                'title' => 'Notifications',
                'message' => 'There is an upcoming event!',
                'icon' => 'images/notification.png',
                'url' => '/',
            ]
        ]);
    }

    public function addJob(Request $request)
    {
        if (Request::ajax()) {
            date_default_timezone_set('Asia/Bangkok');
            $job = (new PushNotification(Request::input('endPoint')))->delay(Carbon::now()->addMinutes(Request::input('delayTime')));
            dispatch($job);
        }
    }

    public function pushNow()
    {
        if (Request::ajax()) {
            $endpoint = Request::input('endPoint');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $headers = array();
            if ($this->startsWith($endpoint, 'https://android.googleapis.com/gcm/send')) {
                $endpointParts = explode('/', $endpoint);
                $registrationId = $endpointParts[count($endpointParts) - 1];
                $endpointUrl = 'https://android.googleapis.com/gcm/send';
                curl_setopt($ch, CURLOPT_URL, $endpointUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"registration_ids\":[\"" . $registrationId. "\"]}");
                curl_setopt($ch, CURLOPT_POST, 1);
                $headers[] = "Authorization: key=AIzaSyD4G4vszy3OucaF6tfxmRk7OMikjhOsYY0";
                $headers[] = "Content-Type: application/json";
            } elseif ($this->startsWith($endpoint, 'https://updates.push.services.mozilla.com/wpush/v1')) {
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                $headers[] = "Ttl: 60";
            } else {
                echo 'error';
                exit;
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }

            curl_close($ch);
        }
    }

    private function startsWith($hayStack, $needle)
    {
        $length = strlen($needle);
        return (substr($hayStack, 0, $length) === $needle);
    }

}
