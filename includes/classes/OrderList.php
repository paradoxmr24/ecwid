<?php
class OrderList
{
    public $list;
    function OrderList()
    {
        $this->list = array();
    }

    function AddOrder($order)
    {
        if (empty($this->list[$order['email']])) {
            $this->list[$order['email']] = array();
        }

        $currentCustomer = $this->list[$order['email']];

        $currentCustomer[] = ['date' => $order['date']];

        usort($currentCustomer, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        $this->list[$order['email']] = array_slice($currentCustomer, 0, 3);
    }
}