<?php

namespace Oxemis\OxiSms;

use Oxemis\OxiSms\Components\SendAPI;
use Oxemis\OxiSms\Components\UserAPI;

/**
 * API Client for OxiSMS
 */
class OxiSmsClient
{

    private string $auth;
    private string $userAgent;
    private string $baseURL;
    public UserAPI $userAPI;
    public SendAPI $sendAPI;

    public function __construct(string $apiLogin, string $apiPassword)
    {

        $this->auth = base64_encode($apiLogin . ":" . $apiPassword);
        $this->userAgent = Configuration::USER_AGENT . PHP_VERSION . '/' . Configuration::WRAPPER_VERSION;
        $this->baseURL = "https://" . Configuration::MAIN_URL;
        $this->userAPI = new UserAPI($this);
        $this->sendAPI = new SendAPI($this);

    }

    public function getAuth(): string
    {
        return $this->auth;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getBaseURL(): string
    {
        return $this->baseURL;
    }

}
