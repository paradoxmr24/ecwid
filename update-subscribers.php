<?php

require_once(__DIR__ . "/includes/classes/MailerLiteRequest.php");
require_once(__DIR__ . "/includes/functions.php");

$customers = getCustomers();

if ($customers === null)
    exit(0);

$mailerLiteRequest = new MailerLiteRequest();

foreach ($customers as $email => $orders) {
    $dates = array_column($orders, 'date');
    $mailerLiteRequest->updateSubscriber($email, $dates);
}
