<?php

function saveCustomersInBatches($list)
{
    $chunks = array_chunk($list, 60, true);
    foreach ($chunks as $index => $chunk) {
        $serializedData = serialize($chunk);
        file_put_contents(dirname(__FILE__) . '/../customers/customers' . $index . '.txt', $serializedData);
    }
}

function getCustomers()
{
    $path = __DIR__ . '/../customers';
    $customers = array();
    foreach (array_diff(scandir($path), ['.', '..']) as $file) {
        $customers = unserialize(file_get_contents($path . '/' . $file));

        return $customers;
    }

    return null;
}