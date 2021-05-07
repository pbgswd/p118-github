<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\CommitteePolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int              $id
 * @property string           $name
 * @property string           $slug
 * @property string           $description
 * @property string           $email
 * @property User             $creator
 * @property bool          $in_menu
 * @property bool          $live
 * @property bool          $allow_comments
 * @property DateTime         $created_at
 * @property DateTime         $updated_at
 * @property User[]           $committee_members
 * @property User[]           $active_committee_members
 * @property CommitteePost[]  $posts
 * @property int|mixed|string|null user_id
 * @method static withoutGlobalScopes()
 */
class Committee extends LiveableModel implements HasAttachment, Searchable
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
        self::class => CommitteePolicy::class,
    ];

    public $sortable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'role',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'allow_comments' => 'boolean',
        'live' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'file_name',
        'image',
        'email',
        'live',
    ];

    /**
     * in urls, what field value is used to identify a Committee record?
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Committee');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->name,
                \route('admin_committee_show', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->name,
            \route('committee', $this->slug)
        );
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function setNameAttribute(string $value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['name'] = $value;
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function committee_members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function active_committee_members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivotIn('role', array_merge(Options::committee_executive_roles(), ['Member' => 'Member']))
            ->withPivot('role', 'committee_id')
            ->with('user_info')
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(CommitteePost::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_committee');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'public';
    }

    public function keepDissociatedAttachments(): bool
    {
        return true;
    }

    public function getAttachmentAccessLevel(): string
    {
        return $this->access_level;
    }

}
