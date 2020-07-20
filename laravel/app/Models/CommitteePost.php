<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int                     $id
 * @property string                  $title
 * @property string                  $slug
 * @property string                  $content
 * @property boolean                 $sticky
 * @property boolean                 $live
 * @property boolean                 $allow_comments
 * @property DateTime                $created_at
 * @property DateTime                $updated_at
 * @property User                    $creator
 * @property Committee               $committee
 * @property CommitteePostComment[]  $post_comments
 */
class CommitteePost extends LiveableModel implements Searchable
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';  //????
//todo committeePost policy
    protected $policies = [
        //Committee::class=>CommitteePolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'sticky' => 'boolean',
        'allow_comments' => 'boolean',
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {

        if(request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_commitee_show', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->name,
            \route('committee', $this->slug),
        );
    }


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'live',
        'sticky',
        'allow_comments',
        'user_id',
    ];

    /**
     * in urls, what field value is used to identify a CommitteePost record?
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function setTitleAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');
        return $this->attributes['title'] = $value;
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function committee(): HasOne
    {
        return $this->hasOne(Committee::class, 'id', 'committee_id');
    }

    /**
     * @return HasMany
     */
    public function post_comments(): HasMany
    {
        return $this->hasMany(CommitteePostComment::class, 'post_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function admin_post_comments(): HasMany
    {
        return $this->hasMany(CommitteePostComment::class, 'post_id', 'id')->withoutGlobalScopes()->orderByDesc('updated_at');
    }
}
