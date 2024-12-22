<?php

namespace App\Services\WebhookClient;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class TodoistSignatureValidator implements SignatureValidator
{
    /**
     * @throws InvalidConfig
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }

        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }

        $computedSignature = base64_encode(hash_hmac('sha256', $request->getContent(), $signingSecret, true));

        return hash_equals($computedSignature, $signature);
    }
}
