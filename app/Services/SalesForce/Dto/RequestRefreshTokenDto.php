<?php
/**
 * File: RequestAccessTokenDto.phpDto.php
 * planstin
 * Author: Layton Everson <layton.everson@gmail.com>
 * YourWeb Solutions
 */

namespace App\Services\SalesForce\Dto;

use App\Entities\OAuthToken;
use App\Services\SalesForce\SalesForceApiParameters;
use stdClass;

class RequestRefreshTokenDto implements SalesForceDtoInterface
{
    /**
     * @var string
     */
    protected $grantType;

    /**
     * @var SalesForceApiParameters
     */
    protected $salesForceApiParams;

    /**
     * @var stdClass|array
     */
    protected $returnData;

    protected $token;

    public function __construct(
        SalesForceApiParameters $salesForceApiParams,
        string $grantType = 'refresh_token'
    ) {
        $this->salesForceApiParams = $salesForceApiParams;
        $this->grantType = $grantType;
    }

    public function toSfObject(): array
    {
        return [
            'grant_type' => $this->grantType,
            'redirect_uri' => $this->salesForceApiParams->getRedirectUri(),
            'client_secret' => $this->salesForceApiParams->getClientSecret(),
            'client_id' => $this->salesForceApiParams->getClientId(),
        ];
    }

    public function fromSfObject(string $data): SalesForceDtoInterface
    {
        $this->returnData = \GuzzleHttp\json_decode($data);
    }

}
