<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class Status extends Enum
{
    const ACCEPTED = 'Accepted';
    const UNDERWAY = 'Underway';
    const COMPLETED = 'Completed';
    const CLOSED = 'Closed';
    const EXCLUDED = 'Excluded';
}
