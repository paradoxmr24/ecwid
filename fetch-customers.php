<?php

// for letting the script execute for infinite amount of time
set_time_limit(0);

require_once(__DIR__ . "/includes/classes/OrderList.php");
require_once(__DIR__ . "/includes/classes/EcwidRequest.php");
require_once(__DIR__ . "/includes/functions.php");

echo '<pre>';

$orderList = new OrderList();
$request = new EcwidRequest('ORDER');

# fetching all the customers along with their 1st, 2nd and 3rd order
while ($orders = $request->next()) {
    echo 'orders:';
    foreach ($orders as $key => $order) {
        $orderList->addOrder([
            'email' => $order['email'],
            'date' => $order['createDate'],
        ]);
    }
}

print_r($orderList->list);

saveCustomersInBatches($orderList->list);