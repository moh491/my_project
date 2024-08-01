<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class Status extends Enum
{
    const PENDING = 'Pending';
    const UNDERWAY = 'Underway';
    const COMPLETED = 'Completed';
    const UnderReview = 'Under Review';
    const CLOSED = 'Closed';
    const EXCLUDED = 'Excluded';
}
