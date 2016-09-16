<?php

namespace iOSPusher;

class Pusher
{
    const APPLE_URL = 'ssl://gateway.sandbox.push.apple.com:2195';

    private $regId;
    private $passphrase;
    private $output;

    public function __construct($passphrase)
    {
        $this->passphrase  = $passphrase;
    }

    /**
     * @param string|array $regId
     * @param string $data
     * @throws \Exception
     */
    public function notify($regId, $data)
    {
        $this->regId = $regId;

        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);

        $fp = stream_socket_client(self::APPLE_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // Open a connection to the APNS server
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        echo 'Connected to APNS' . PHP_EOL;
        $body['aps'] = $data;
        $payload = json_encode($body);

        $msg = chr(0) . pack('n', 32) . pack('H*', $this->regId) . pack('n', strlen($payload)) . $payload; // Build the binary notification
        $result = fwrite($fp, $msg, strlen($msg)); // Send it to the server
        if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;
        $this->output = $result;

        fclose($fp);
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
}
