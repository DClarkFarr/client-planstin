<?php
/**
 * File: AddClientApiCall.php
 * planstin
 * Author: Layton Everson <layton.everson@gmail.com>
 * YourWeb Solutions
 */

namespace App\Services\SalesForce\ApiCall;

use App\Services\SalesForce\Dto\AddContactDto;

class AddContact extends AbstractRestApiCall
{
    protected function prepareRequest(): void
    {
        //Add Authorization Header
        $this->authorizeWithToken();

        //Set method to POST
        $this->requestMethod = self::HTTP_METHOD_POST;

        //Send request with JSON body
        $this->requestBodyType = self::REQUEST_BODY_JSON;

        $this->setRequestBodyParams($this->data->toSfObject());
    }

    protected function getRequestUrl(): string
    {
        return $this->getObjectBaseUrl('Contact');
    }

    protected function getDtoObjectType(): string
    {
        return AddContactDto::class;
    }

}
