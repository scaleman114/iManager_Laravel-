<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContractType extends Enum
{
    const Service = 0;
    const Hire = 1;
    const Touchoffice = 2;
    const Webshop = 3;
}