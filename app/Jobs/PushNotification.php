<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class PushNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $endpoint;

    /**
     * Create a new job instance.
     *
     * @param  string  $endpoint
     * @return void
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $endpoint = $this->endpoint;
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"registration_ids\":[\"". $registrationId. "\"]}");
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

    private function startsWith($hayStack, $needle)
    {
        $length = strlen($needle);
        return (substr($hayStack, 0, $length) === $needle);
    }
}
