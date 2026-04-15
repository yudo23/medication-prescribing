<?php

namespace App\Enums;

enum PatientRecordEnum
{
    const STATUS_UNPAID = 1;
    const STATUS_PAID = 2;

    public static function status()
    {
        $roles = [
            self::STATUS_UNPAID => "Belum Bayar",
            self::STATUS_PAID => "Sudah Bayar",
        ];

        return $roles;
    }
}
