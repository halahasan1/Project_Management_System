<?php

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttachmentObserver
{

    public function deleted(Attachment $attachment): void
    {
        $disk = $attachment->disk;
        $path = $attachment->path;

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
            Log::info('Attachment file deleted from storage', [
                'attachment_id' => $attachment->id,
                'path' => $path
            ]);
        } else {
            Log::warning('Attachment file not found in storage', [
                'attachment_id' => $attachment->id,
                'path' => $path
            ]);
        }
    }
}
