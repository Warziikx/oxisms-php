<?php

namespace Oxemis\OxiSMS\Components;

use Oxemis\OxiSMS\ApiClient;
use Oxemis\OxiSMS\ApiException;
use Oxemis\OxiSMS\Objects\Message;
use Oxemis\OxiSMS\Objects\ScheduledSending;
use Oxemis\OxiSMS\Objects\Sending;

/**
 * Class for https://api.oxisms.com/doc/#/send
 */
class SendAPI extends Component
{

    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        parent::__construct($apiClient);
    }

    /**
     * @param Message $message  The Message you want to send.
     * @return Sending          Informations about the sending (see API doc for details).
     * @throws ApiException
     */
    public function send(Message $message): Sending
    {
        return $this->sendJSON(json_encode($message));
    }

    /**
     * @param string $JSONMessage   The JSON representation of the message you want to send (see :https://api.oxisms.com/doc/#/send/post_send)
     * @return Sending              Informations about the sending (see API doc for details).
     * @throws ApiException
     */
    public function sendJSON(string $JSONMessage): Sending
    {
        $result = $this->request("POST", "/send", null, $JSONMessage);
        return (Sending::mapFromStdClass($result));
    }

    /**
     * @param Message $message      The Message you want to send.
     * @return Sending              Information about the future cost of the sending (see API doc for details).
     * @throws ApiException
     */
    public function getCostOfMessage(Message $message): Sending
    {
        return $this->getCostOfMessageJSON(json_encode($message));
    }

    /**
     * @param string $JSONMessage   The JSON representation of the message you want to send (see :https://api.oxisms.com/doc/#/send/post_send)
     * @return Sending              Information about the sending (see API doc for details).
     * @throws ApiException
     */
    public function getCostOfMessageJSON(string $JSONMessage): Sending
    {
        $result = $this->request("POST", "/cost", null, $JSONMessage);
        return Sending::mapFromStdClass($result);
    }

    /**
     * @return array<ScheduledSending>|null           List of scheduled sendings.
     * @throws ApiException
     */
    public function getScheduled(): ?array
    {
        $sendings = $this->request("GET", "/scheduled");
        if (!is_null($sendings)) {
            $list = [];
            foreach ($sendings as $sending) {
                $list[] = ScheduledSending::mapFromStdClass($sending);
            }
            return $list;
        } else {
            return null;
        }
    }

    /**
     * @param string $sendingID The ID of the sending you want to cancel.
     * @return bool
     * @throws ApiException
     */
    public function deleteScheduled(string $sendingID): bool
    {
        $result = $this->request("DELETE", "/scheduled", ["sendingid" => $sendingID]);
        return ($result->Code == 200);
    }

}
