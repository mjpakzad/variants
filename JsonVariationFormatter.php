<?php
namespace App;

class JsonVariationFormatter implements FormattableVariation
{
    /**
     * Format and return data as encoded json.
     *
     * @param \App\Variation $variation
     *
     * @return false|string
     */
    public function format(Variation $variation)
    {
        return json_encode($variation->getData());
    }
}