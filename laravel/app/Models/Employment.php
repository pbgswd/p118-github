<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\EmploymentPolicy;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $live
 * @property boolean $status
 * @property User $users
 * @property \DateTime $deadline
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property Attachment $attachments
 * @property string $getAttachmentFolder
 */

class Employment extends Model implements HasAttachment, Searchable
{
    use Sortable;

    protected $table = 'employment';

    protected $policies = [
        Employment::class => EmploymentPolicy::class,
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('job_view', $this->id);

        $this->name = $this->title;

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url,
        );
    }

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'live',
        'deadline',
        ];

    /**
     * @var array
     */
    public $sortable = [
        'title',
        'description',
        'status',
        'live',
        'deadline',
        ];

    protected $dates = [
            'deadline',
            'created_at',
            'updated_at'
        ];

    protected $casts = [
            'live' => 'boolean',
            'status' => 'boolean',
        ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'attachment_employment');
    }

    public function getAttachmentFolder(): string
    {
        return 'employment';
    }
}
