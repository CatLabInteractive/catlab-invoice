<?php

namespace FI\Events\Listeners;

use FI\Events\AttachmentDeleted;

class AttachmentDeletedListener
{
    public function __construct()
    {
        //
    }

    public function handle(AttachmentDeleted $event)
    {
        $filePath = $event->attachment->attachable->attachment_path . '/' . $event->attachment->filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
