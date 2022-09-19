<?php
require_once('vendor/autoload.php');

$variation = new \App\Variation();
$data = [
    [
        'id'        => 1,
        'title'     => 'A1',
        'seller_id' => 1,
        'price'     => 15000,
        'rate'      => 4.5,
    ],
    [
        'id'        => 2,
        'title'     => 'A2',
        'seller_id' => 1,
        'price'     => 20000,
        'rate'      => 3.2,
    ],
    [
        'id'        => 3,
        'title'     => 'A3',
        'seller_id' => 2,
        'price'     => 68000,
        'rate'      => 4.8,
    ],
    [
        'id'        => 4,
        'title'     => 'A1',
        'seller_id' => 3,
        'price'     => 14500,
        'rate'      => 4.4,
    ],
    [
        'id'        => 5,
        'title'     => 'A1',
        'seller_id' => 4,
        'price'     => 15100,
        'rate'      => 5,
    ],
    [
        'id'        => 6,
        'title'     => 'A2',
        'seller_id' => 3,
        'price'     => 18000,
        'rate'      => 4.7,
    ],
    [
        'id'        => 7,
        'title'     => 'A3',
        'seller_id' => 4,
        'price'     => 68500,
        'rate'      => 4.9,
    ],
    [
        'id'        => 8,
        'title'     => 'A1',
        'seller_id' => 2,
        'price'     => 15500,
        'rate'      => 5,
    ],
];
$variation->summarize($data);
$formatter = new \App\ArrayVariationFormatter();
echo '<pre>' . print_r($formatter->format($variation), true) . '</pre>';
?>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th {
        background-color: #96D4D4;
    }
    th, td {
        padding: 15px;
    }
</style>