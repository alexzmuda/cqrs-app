<?php


namespace App\Infrastructure\JToken;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

final class JToken
{
    private const DEFAULT_EXPIRE_SECONDS = 60 * 30; // 30 minutes
    private const PAYLOAD_CREATED_AT_FIELD = 'created_at';
    private const PAYLOAD_APP_FIELD = 'app';
    private const PAYLOAD_DATA_FIELD = 'data';

    private string $token;
    private array $payload = [];

    private int $expireSeconds;
    private bool $isValid = false;
    private bool $isExpired = false;


    public function __construct(string $token, ?int $expireSeconds = null)
    {
        $this->expireSeconds = $expireSeconds ?? self::DEFAULT_EXPIRE_SECONDS;
        $this->token = $token;
        $this->unpack();
    }


    public static function create(array $payloadData)
    {
        $header = self::base64UrlEncode(self::getJsonHeader());

        $payload = self::base64UrlEncode(
            json_encode(
                [
                    self::PAYLOAD_DATA_FIELD => $payloadData,
                    self::PAYLOAD_CREATED_AT_FIELD => time(),
                    self::PAYLOAD_APP_FIELD => self::getAppName(),
                ]
            )
        );

        $signature = self::createSignature($header, $payload);

        return Crypt::encryptString($header . '.' . $payload . '.' . $signature);
//        return $header . '.' . $payload . '.' . $signature;
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function isExpired()
    {
        return $this->isExpired;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }


    private function unpack()
    {
        try {
            $decrypted = Crypt::decryptString($this->token);
        } catch (\Exception $e) {
            return;
        }
//        $decrypted = $this->token;
        $parts = explode('.', $decrypted);
        $header = $parts[0];
        $payload = $parts[1];
        $signature = $parts[2];

        $checkSignature = self::createSignature($header, $payload);

        $this->isValid = ($signature === $checkSignature);

        if ( ! $this->isValid) {
            return;
        }

        $payload = json_decode(base64_decode($payload), true);

        if ( ! is_array($payload)) {
            $this->isValid = false;
            return;
        }

        if ($payload[self::PAYLOAD_APP_FIELD] !== self::getAppName()) {
            $this->isValid = false;
            return;
        }

        $expireAt = Carbon::createFromTimestamp($payload[self::PAYLOAD_CREATED_AT_FIELD])->addSeconds($this->expireSeconds);
        $this->isExpired = $expireAt < Carbon::now('UTC');


        if ($this->isValid && ! $this->isExpired) {
            $this->payload = $payload[self::PAYLOAD_DATA_FIELD];
        }
    }

    private static function getJsonHeader(): string
    {
        return json_encode(
            [
                'typ' => 'JToken',
                'alg' => 'HS256',
            ]
        );
    }

    private static function base64UrlEncode($text)
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }

    private static function getTokenKey(): string
    {
        return env('TOKEN_KEY', env('APP_KEY'));
    }

    private static function getAppName(): string
    {
        return env('APP_NAME', 'JToken');
    }

    private static function createSignature(string $header, string $payload): string
    {
        return self::base64UrlEncode(
            hash_hmac(
                'sha256',
                $header . "." . $payload,
                self::getTokenKey(),
                true
            )
        );
    }
}
