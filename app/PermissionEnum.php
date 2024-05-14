<?php

namespace App;

enum PermissionEnum: string
{
    case SPECIAL_PERM__ALLOW_ALL = "specialPerm.allowAll";
    case SPECIAL_PERM__ALLOW_FOR_ADMIN = "specialPerm.allowForAdmin";
    case SPECIAL_PERM__MUST_BE_LOGGED_IN = "specialPerm.mustBeLoggedIn";
    case SPECIAL_PERM__MUST_BE_LOGGED_OFF = "specialPerm.mustBeLoggedOff";
    case PROJECTS__INDEX = "projects.index";
    case PROJECTS__DETAIL = "projects.detail";
    case PROJECTS__ADD = "projects.add";
    case PROJECTS__EDIT = "projects.edit";
    case PROJECTS__DELETE = "projects.delete";
    case BILLINGS__INDEX = "billings.index";
    case BILLINGS__ADD = "billings.add";
    case BILLINGS__EDIT = "billings.edit";
    case BILLINGS__DELETE = "billings.delete";
    case BILLINGS__CHANGE_STATUS = "billings.change-status";
    case FILES__DOWNLOAD = "files.download";
    case FILES__SHOW = "files.show";
    case FILES__UPLOAD = "files.upload";
}
