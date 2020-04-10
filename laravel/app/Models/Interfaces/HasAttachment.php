<?php


namespace App\Models\Interfaces;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasAttachment
{

    public function getAttachmentFolder(): string;

    public function keepDissociatedAttachments(): bool;

    public function attachments(): BelongsToMany;

    public function getAttachmentAccessLevel(): string;

}
