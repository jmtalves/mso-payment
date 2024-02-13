<?php

// start
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", "error.log");
require_once(__DIR__ . "/../autoload.php");

use Libraries\MessageBroker;
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
    MessageBroker::sendMessage(
        "userucupdateStatus",
        [
            "iduser" => $data['iduser'],
            "iduc" => $data['iduc'],
            "status " => 1
        ]
    );
}

/**
 * compensateForPaymentFailure
 * @param array $data
 */
function compensateForPaymentFailure($data)
{
    MessageBroker::sendMessage(
        "userucupdateStatus",
        [
            "iduser" => $data['iduser'],
            "iduc" => $data['iduc'],
            "status " => 0
        ]
    );
}

MessageBroker::processMessage("createPayment", "createPaymentData");
exit();
