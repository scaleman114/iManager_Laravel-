<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RepairType extends Enum
{
    const Retail = 0;
    const Industrial = 1;
    const Warranty = 2;
    const Hire = 3;
}