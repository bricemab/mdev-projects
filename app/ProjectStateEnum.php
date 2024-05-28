<?php

namespace App;

enum ProjectStateEnum: string
{
    case NOT_VALIDATED = "NOT_VALIDATED";
    case VALIDATED = "VALIDATED";
    case PENDING = "PENDING";
    case FINISHED = "FINISHED";

    static function getLabel($label) {
        switch ($label) {
            case self::NOT_VALIDATED->value:
                $label = __("projects.enum-states.not-validated");
                break;
            case self::VALIDATED->value:
                $label = __("projects.enum-states.validated");
                break;
            case self::PENDING->value:
                $label = __("projects.enum-states.pending");
                break;
            case self::FINISHED->value:
                $label = __("projects.enum-states.finished");
                break;
            default:
                $label = __("global.translate-not-found");
                break;
        }
        return $label;
    }
}
