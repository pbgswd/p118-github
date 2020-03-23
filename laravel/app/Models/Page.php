<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\PagePolicy;
use Conner\Tagging\Taggable;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property User $user
 * @property string $description
 * @property string $content
 * @property string $access_level
 * @property int $sort_order
 * @property boolean $live
 * @property boolean $in_menu
 * @property boolean $allow_comments
 * @property Topic $topics
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property PageAttachmet $attachment
 */
class Page extends Model implements HasAttachment, Searchable
{
    use Sortable;
    use Taggable;

    public function getSearchResult(): SearchResult
    {
        $url = route('page_show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url,
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable =
        [
            'title',
            'description',
            'content',
            'access_level',
            'sort_order',
            'live',
            'in_menu',
            'allow_comments',
        ];

    protected $policies = [
        Page::class => PagePolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
        'allow_comments',
        'created_at',
        'updated_at',
    ];

    protected $dates =
        [
            'created_at',
            'updated_at'
        ];

    protected $casts =
        [
            'in_menu' => 'boolean',
            'allow_comments' => 'boolean',
            'live' => 'boolean',
        ];


    /**
     * in urls, what field value is used to identify a Topic record?
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['title'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'attachment_page');
    }

    public function getAttachmentFolder(): string
    {
        return 'public';
    }
}
