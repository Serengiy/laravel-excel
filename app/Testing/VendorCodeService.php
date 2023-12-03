<?php

namespace App\Testing;

use Faker\Provider\Base;

class VendorCodeService extends Base
{
    public function vendorCode(): string
    {
        return 'A' . str_pad($this->unique()->numberBetween(1, 999999999999), 12, '0', STR_PAD_LEFT);
        ;
    }
}
