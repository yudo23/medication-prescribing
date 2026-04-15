<?php

namespace App\Helpers;

use App\Models\LogUser;
use Auth;

class LogHelper
{
    public static function log(
        string $model,
        int $referenceId,
        int $type,
        string|null $note = null
    ): void {
        if (!Auth::check()) {
            return;
        }

        LogUser::create([
            'author_id' => Auth::id(),
            'reference_id' => $referenceId,
            'model' => $model,
            'type' => $type,
            'note' => $note,
        ]);
    }
}