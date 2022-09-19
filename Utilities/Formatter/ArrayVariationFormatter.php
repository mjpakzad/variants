<?php
namespace App\Utilities\Formatter;

use App\Variation;

class ArrayVariationFormatter implements FormattableVariation
{
    /**
     * Return data as array.
     *
     * @param \App\Variation $variation
     *
     * @return array
     */
    public function format(Variation $variation)
    {
        return $variation->getData();
    }
}