<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Storage;
use Log;

class UploadHelper
{

  public static function upload_file($requestFile, string $folder, array $allowExt = [], $allowSize = 2097152, bool $public = true)
  {

    $data = [];
    try {
      //Path
      $path = 'public';

      //File Extension
      $fileExtension = $requestFile->getClientOriginalExtension();

      //File Size
      $fileSize = $requestFile->getSize();

      //Public Option
      $publicOptions = $public ? "public" : "private";

      //If file large than
      if ($fileSize > $allowSize) {
        $data["IsError"] = TRUE;
        $data["Message"] = "Maximum file size is 5 MB";
        goto ResultData;
      }

      //If extension is not valid
      if (count($allowExt) > 0) {
        if (!in_array(strtolower($fileExtension), $allowExt)) {
          $data["IsError"] = TRUE;
          $data["Message"] = "The file format allowed is " . implode(" , ", $allowExt);
          goto ResultData;
        }
      }

      //New File Name
      $newFileName = Str::random(100) . "." . $fileExtension;

      if (!is_dir(storage_path("app/$path/$folder/"))) {
        mkdir(storage_path("app/$path/$folder/"), 0777, true);
      }

      if ($public) {
        Storage::disk('public')->putFileAs($folder, $requestFile, $newFileName);
      } else {
        Storage::disk('local')->putFileAs($folder, $requestFile, $newFileName);
      }

      $data["IsError"] = FALSE;
      $data["Message"] = "Successfully uploaded file";
      $data["Path"] = "storage/" . $folder . "/" . $newFileName;
      $data["Filename"] = $newFileName;
      goto ResultData;
    } catch (\Throwable $th) {
      Log::emergency($th->getMessage());
      $data["IsError"] = TRUE;
      $data["Message"] = $th->getMessage();
      goto ResultData;
    }

    ResultData:
    return $data;
  }
}
