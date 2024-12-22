<?php

namespace App\Services\WebhookClient;

use App\Services\Google\Config;
use Google\Auth\AccessToken;
use Illuminate\Http\Request;
use Log;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;
use Str;

class GooglePubSubJwtValidator implements SignatureValidator
{
    public function __construct(private readonly Config $config) {}

    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $authHeader = $request->header('Authorization');
        if (! $authHeader || ! Str::startsWith($authHeader, 'Bearer ')) {
            return false;
        }

        $jwt = Str::after($authHeader, 'Bearer ');

        try {
            return $this->validateJwt($jwt);
        } catch (\Exception $e) {
            Log::error('Pub/Sub JWT validation failed: '.$e->getMessage());

            return false;
        }
    }

    private function validateJwt(string $jwt): bool
    {
        $accessToken = new AccessToken;
        $payload = $accessToken->verify($jwt);

        return Str::startsWith($payload['aud'], $this->config->getWebhookEndpointHost())
            && $payload['email_verified']
            && $payload['email'] === $this->config->getServiceAccountEmail();
    }
}
