<?php

namespace AndroidPusher;


class Pusher
{
    const GOOGLE_GCM_URL = 'https://android.googleapis.com/gcm/send';
    const GOOGLE_FCM_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Server Key from Google | Firebase console
     *
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * Optional proxy url
     * Defaults to null
     *
     * @var null|string $proxy
     */
    private $proxy;

    /**
     * Use Firebase Cloud Messaging
     * Defaults to false (uses deprecated Google Cloud Messaging)
     *
     * @var bool $useFCM
     */
    private $useFCM;

    /**
     * cUrl stringified result | null on error
     *
     * @var null|string $output
     */
    private $output;

    /**
     * Pusher constructor
     * @param string $apiKey
     * @param string $proxy
     * @param bool $useCFM
     */
    public function __construct($apiKey, $proxy = null, $useCFM = false)
    {
        $this->apiKey = $apiKey;
        $this->proxy = $proxy;
        $this->useFCM = $useCFM;
    }

    /**
     * @param string|array $regIds
     * @param string $data
     * @throws \Exception
     */
    public function notify($regIds, $data)
    {
        $ch = curl_init();
        if ($this->useFCM) {
            curl_setopt($ch, CURLOPT_URL, self::GOOGLE_FCM_URL);
        } else {
            curl_setopt($ch, CURLOPT_URL, self::GOOGLE_GCM_URL);
        }
        if (!is_null($this->proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!$this->useFCM) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostFields($regIds, $data));

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        $this->output = $result;
    }

    /**
     * @return array
     */
    public function getOutputAsArray()
    {
        return json_decode($this->output, true);
    }

    /**
     * @return object
     */
    public function getOutputAsObject()
    {
        return json_decode($this->output);
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        return [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json'
        ];
    }

    /**
     * @param string|array $regIds
     * @param string|array $data
     * @return string
     */
    private function getPostFields($regIds, $data)
    {
        if ($this->useFCM) {
            is_string($regIds) ? $recipientKey = 'to' : $recipientKey = 'registration_ids';
            $fields = [
                $recipientKey => $regIds,
                'data' => is_string($data) ? ['message' => $data] : $data,
            ];
        } else {
            $fields = [
                'registration_ids' => is_string($regIds) ? [$regIds] : $regIds,
                'data' => is_string($data) ? ['message' => $data] : $data,
            ];
        }

        return json_encode($fields, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
}
