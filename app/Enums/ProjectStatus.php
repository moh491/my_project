<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class ProjectStatus extends Enum
{
    const Open = 'Open';
    const UNDERWAY = 'Underway';
    const COMPLETED = 'Completed';
    const UnderReview = 'Under Review';
    const CLOSED = 'Closed';

}
