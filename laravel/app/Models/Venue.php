<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\VenuePolicy;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int        $id
 * @property string     $slug
 * @property string     $name
 * @property string     $description
 * @property string     $url
 * @property string     $access_level
 * @property bool       $live
 * @property User       $user
 * @property DateTime   $created_at
 * @property DateTime   $updated_at
 * @property AgreementHandler $agreement_handler
 * @method static withoutGlobalScopes()
 */
class Venue extends LiveableModel implements HasAttachment, Searchable
{
    use Sortable;

    protected $policies = [
        self::class => VenuePolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'access_level',
        'live',
        'admin_notes',
        'file_name',
        'image',

    ];

    public $sortable = [
        'id',
        'name',
        'access_level',
        'live',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'live' => 'boolean',
    ];

    /**
     * Venue constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->access_level = AccessLevelConstants::MEMBERS;
    }

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Venue');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->name,
                \route('venue_edit', $this->slug)
            );
        }

        return new SearchResult(
            $this,
            $this->name,
            \route('venue', $this->slug)
        );
    }

    /**
     * in urls, what field value is used to identify a Topic record?
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
    public function setNameAttribute($value): string
    {
        $this->attributes['slug'] = Str::slug($value, '-');

        return $this->attributes['name'] = $value;
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }


    /**
     * @return BelongsToMany
     */
    public function agreements(): BelongsToMany
    {
        return $this->belongsToMany(Agreement::class)
            ->whereRaw('until > NOW()')
            ->where([['live', 1],
                ['access_level', 'public']
            ])->sortable()
            ->orderBy('until');
    }

    /**
     * @return BelongsToMany
     */
    public function all_agreements(): BelongsToMany
    {
        return $this->belongsToMany(Agreement::class)
            ->sortable()
            ->orderBy('title');
    }


    /**
     * @return BelongsToMany
     */
    public function member_agreements(): BelongsToMany
    {
        return $this->belongsToMany(Agreement::class)
            ->where('live', 1)
            ->sortable()
            ->orderBy('title');
    }


    /**
     * @return HasOne
     */
    public function agreement_handler(): HasOne
    {
        return $this->hasOne(AgreementHandler::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
       return $this->belongsToMany(Attachment::class, 'attachment_venue');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'org_venue';
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
