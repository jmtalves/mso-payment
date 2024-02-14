<?php

// start
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", "error.log");
require_once(__DIR__ . "/../autoload.php");

use Libraries\MessageBroker;
use Libraries\Encrypt;
use Libraries\Request;
use Models\Payment;

/**
 * createPaymentData
 * @param array $data
 */
function createPaymentData($data)
{
    $model = new Payment();
    $model->iduser = $data["iduser"];
    $model->iduc = $data["iduc"];
    $model->fail = $data["simulate_fail"];
    $model->insert();
    if ($data["simulate_fail"]) {
        compensateForPaymentFailure($data);
    } else {
        simulatePaymentProcessing($data);
    }
}

/**
 * simulatePaymentProcessing
 * @param array $data
 */
function simulatePaymentProcessing($data)
{
    $authorization = Encrypt::encryptJwt("internal-" . $data['iduser'] . "-1");
    $url = "http://" . getenv('URL_SERVICE_USERUC') . "/api/useruc/" . $data['user'] . "/" . $data['uc'];
    Request::callApi("PUT", $authorization['token'], $url, ["status" => 1]);
}

/**
 * compensateForPaymentFailure
 * @param array $data
 */
function compensateForPaymentFailure($data)
{
    $authorization = Encrypt::encryptJwt("internal-" . $data['iduser'] . "-1");
    $url = "http://" . getenv('URL_SERVICE_USERUC') . "/api/useruc/" . $data['user'] . "/" . $data['uc'];
    Request::callApi("DELETE", $authorization['token'], $url, ["status" => 0]);
}

MessageBroker::processMessage("createPayment", "createPaymentData");
exit();
