<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\MeetingPolicy;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $live
 * @property User $users
 * @property \DateTime $date
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property MeetingAttachment $attachments
 */
class Meeting extends Model implements HasAttachment, Searchable
{
    use Sortable;

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('meeting', $this->id);

        $this->name = $this->title;

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url,
        );
    }

    protected $policies = [
        Meeting::class => MeetingPolicy::class,
        ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'title',
            'description',
            'date',
            'live',
        ];

    public $sortable =
        [
            'id',
            'title',
            'live',
            'date',
            'created_at',
            'updated_at',
        ];

    protected $dates =
        [
            'date',
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'live' => 'boolean',
        ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'attachment_meeting');
    }

    public function getAttachmentFolder(): string
    {
        return 'meetings';
    }
}
