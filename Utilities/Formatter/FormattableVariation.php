<?php
namespace App\Utilities\Formatter;

use App\Variation;

interface FormattableVariation
{
    public function format(Variation $variation);
}