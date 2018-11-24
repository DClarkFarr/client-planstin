<?php

/**
 * File: RequestAccessToken.php
 * planstin
 * Author: Layton Everson <layton.everson@gmail.com>
 * YourWeb Solutions
 */

namespace App\Services\SalesForce\ApiCall;

use App\Services\SalesForce\Dto\RequestAccessTokenDto;
use App\Services\SalesForce\Dto\RequestRefreshTokenDto;
use App\Services\SalesForce\SalesForceTokenService;

class RequestRefreshToken extends AbstractRestApiCall
{
    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_POST;
    }

    public function getRequestUrl(): string
    {
        return $this->apiParameters->getApiEndpoint() . SalesForceTokenService::TOKEN_URI;
    }

    protected function getDtoObjectType(): string
    {
        return RequestRefreshTokenDto::class;
    }

    protected function prepareRequest(): void
    {
        $this->requestBodyType = self::REQUEST_BODY_FORM;
        $this->requestMethod = self::HTTP_METHOD_POST;
    }
}
