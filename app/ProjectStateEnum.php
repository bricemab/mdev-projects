<?php

namespace App;

enum ProjectStateEnum: string
{
    case NOT_VALIDATED = "NOT_VALIDATED";
    case VALIDATED = "VALIDATED";
    case PENDING = "PENDING";
    case FINISHED = "FINISHED";

    static function getLabel($label) {
        return $label;
    }
}
