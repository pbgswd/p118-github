<?php

namespace App\Models;

use App\Policies\CommitteePolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\SearchResult;
use Spatie\Searchable\Searchable;
use function route;


/**
 * @property int              $id
 * @property string           $name
 * @property string           $slug
 * @property string           $description
 * @property string           $access_level
 * @property string           $email
 * @property User             $creator
 * @property boolean          $in_menu
 * @property boolean          $live
 * @property boolean          $allow_comments
 * @property DateTime         $created_at
 * @property DateTime         $updated_at
 * @property User[]           $committee_members
 * @property User[]           $active_committee_members
 * @property CommitteePost[]  $posts
 * @method static withoutGlobalScopes()
 */
class Committee extends LiveableModel implements Searchable
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
        Committee::class => CommitteePolicy::class,
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
        'updated_at'
    ];

    protected $casts = [
        'in_menu' => 'boolean',
        'allow_comments' => 'boolean',
        'live' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'access_level',
        'live',
        'sort_order',
        'in_menu',
        'allow_comments',
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
         return new SearchResult(
            $this,
            $this->name,
            route(request()->route()->getName(), $this->slug)
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
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(CommitteePost::class);
        //->with(User::class);
        //todo with associated author   return $this->belongsTo(User::class);
    }
}
