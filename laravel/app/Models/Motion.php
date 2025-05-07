<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\MotionPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Motion extends Model implements HasAttachment, Searchable
{
    /** @use HasFactory<\Database\Factories\MotionFactory> */
    use HasFactory;

    protected $table = 'motions';

    protected $guard_name = 'web';

    //    protected $policies = [
    //        self::class => Motion::class,
    //    ];

    protected $fillable = [
        'title',
        'description',
        'submission_type',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    protected $policies = [
        self::class => MotionPolicy::class,
    ];

    public function user(): BelongsTo
    {
        // return $this->hasOne(User::class, 'id', 'user_id');

        return $this->belongsTo(User::class);
    }

    public function meeting(): HasOne
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_motion');
    }

    public function getAttachmentFolder(): string
    {
        return 'motions';
    }

    public function keepDissociatedAttachments(): bool
    {
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }

    // todo finish search
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Motion');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_motion_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('motion', $this->id)
        );
    }
}
