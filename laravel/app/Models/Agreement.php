<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\AgreementPolicy;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $access_level
 * @property bool $live
 * @property int $user_id
 * @property User $user
 * @property Attachment[] $attachments
 * @property Venue[] $venues
 * @property Organization[] $organizations
 * @property AgreementHandler[] $agreement_handlers
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $from
 * @property DateTime $until
 *
 * @method static withoutGlobalScopes()
 * @method static whereNotIn(string $string, $map)
 */
class Agreement extends LiveableModel implements HasAttachment, Searchable
{
    use HasFactory;
    use Sortable;

    protected $policies = [
        self::class => AgreementPolicy::class,
    ];

    public $sortable = [
        'id',
        'title',
        'from',
        'until',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'live',
        'access_level',
        'from',
        'until',
        'user_id',
    ];

    protected $casts = [
        'from' => 'datetime',
        'until' => 'datetime',
        'live' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->access_level = AccessLevelConstants::MEMBERS;
    }

    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('Agreement');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('agreement_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('agreement_show', $this->id)
        );
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'attachment_agreement')->orderBy('id', 'desc');
    }

    public function agreement_handlers(): BelongsToMany
    {
        return $this->belongsToMany(AgreementHandler::class);
    }

    public function venues(): BelongsToMany
    {
        return $this->belongsToMany(Venue::class, 'agreement_venue');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'agreement_organization');
    }

    public function getAttachmentFolder(): string
    {
        return 'agreements';
    }

    public function keepDissociatedAttachments(): bool
    {
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }
}
