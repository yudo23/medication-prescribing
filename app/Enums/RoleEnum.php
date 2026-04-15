<?php

namespace App\Enums;

enum RoleEnum
{
    const ADMINISTRATOR = "Administrator";
    const DOKTER = "Dokter";
    const APOTEKER = "Apoteker";

    public static function roles()
    {
        $roles = [
            self::ADMINISTRATOR,
            self::DOKTER,
            self::APOTEKER,
        ];

        return $roles;
    }
}
