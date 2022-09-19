<?php
require_once('vendor/autoload.php');

$variants   = config('variants');
$orders     = config('orders');

/**
 * Summarize variants and set data property.
 */
$variation = new \App\Variation();
$variation->summarize($variants);

/**
 * Read data property of Variants using getData method and format data.
 */
$formatter = new \App\Utilities\Formatter\HtmlVariationFormatter();
echo $formatter->format($variation);
