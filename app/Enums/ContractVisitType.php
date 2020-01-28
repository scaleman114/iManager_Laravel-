<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContractVisitType extends Enum
{

    const Gold = 0;
    const Silver = 1;
    const Bronze = 2;
    const Total3Visit = 3;
    const Total4Visit = 4;
    const Calibration1Visit = 5;
    const Calibration2Visit = 6;
    const Calibration3Visit = 7;
    const Calibration4Visit = 8;
}