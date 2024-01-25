<?php
require_once(__DIR__ . "/includes/functions.php");

[$customers, $file] = getCustomers();

if ($customers === null)
    exit(0);

require_once(__DIR__ . "/includes/classes/MailerLiteRequest.php");

echo "<pre>";
echo "working on file: " . $file . "<br><br><br><br>";

$mailerLiteRequest = new MailerLiteRequest();

foreach ($customers as $email => $orders) {
    $dates = array_column($orders, 'date');
    $mailerLiteRequest->updateSubscriber($email, $dates);
}

deleteCustomerFile($file);