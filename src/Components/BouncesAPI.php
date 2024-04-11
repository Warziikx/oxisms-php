<?php

namespace Oxemis\OxiSMS\Components;

use Oxemis\OxiSMS\ApiClient;
use Oxemis\OxiSMS\ApiException;

/**
 * Class for https://api.oxisms.com/doc/#/bouncelist
 */
class BouncesAPI extends Component
{

    public function __construct(ApiClient $apiClient)
    {
        parent::__construct($apiClient);
    }

    /**
     * @param int $lastId       (Optional) Get the bounces added since this ID.
     * @return array<string>    List of bounced phone numbers (the indexes in the array are the IDs of the bounced numbers).
     * @throws ApiException
     */
    public function getBouncedPhoneNumbers(int $lastId = -1): ?array
    {
        $result = $this->request("GET", "/bouncelist", ["lastid" => $lastId]);
        if (!is_null($result)) {
            $list = [];
            foreach ($result->data as $data) {
                $list[$data->Id] = $data->PhoneNumber;
            }
            return $list;
        } else {
            return null;
        }
    }

    /**
     * @param string $phoneNumber   The phone number you want to add to your bouncelist (you can add multiple numbers separated by ';').
     * @return bool                 OK means that the number has been added.
     * @throws ApiException
     */
    public function addPhoneNumberToBouncelist(string $phoneNumber): bool
    {
        $result = ($this->request("POST", "/bouncelist", ["phonenumbers" => $phoneNumber]));
        return ($result->Code == 200);
    }

    /**
     * @param string $phoneNumber   The phone number you want to remove from your bouncelist (you can add multiple numbers separated by ';').
     * @return bool                 OK means that the number has been removed.
     * @throws ApiException
     */
    public function deleteEmailInBouncelist(string $phoneNumber): bool
    {
        $result = ($this->request("DELETE", "/bouncelist", ["phonenumbers" => $phoneNumber]));
        return ($result->Code == 200);
    }

}
