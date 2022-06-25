<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case DIRECTOR = 'director';
    case GUARD = 'guard';
    case PRISONER = 'prisoner';

}
