<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    protected $guarded = false;

    public static function putAndCreateFile($dataFile):string
    {
        $file = Storage::disk('public')->put('files', $dataFile);
        File::query()->create([
            'path' => $file,
            'title' => $dataFile->getClientOriginalName()
        ]);
        return $file;
    }
}
