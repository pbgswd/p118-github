<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use App\Models\Interfaces\HasAttachment;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class User.
 *
 * @property int           $id
 * @property string        $name
 * @property string        $email
 * @property string        $password
 * @property \DateTime     $created_at
 * @property \DateTime     $updated_at
 * @property PhoneNumber   $phone_number
 * @property UserInfo      $user_info
 * @property Address       $address
 * @property Membership    $membership
 * @property Attachment[]  $attachments
 * @property Committee[]   $committee_memberships
 * @method static has(string $string)
 */
class User extends Authenticatable implements HasAttachment, Searchable
{
    use HasFactory;
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    /**
     * @var string[]
     */
    protected $policies = [
        self::class => UserPolicy::class,
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'is_banned',
    ];

    protected $dates = [
        'banned_until',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->name,
                \route('user_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->name,
            \route('member', $this->id)
        );
    }

    /**
     * @return HasOne
     */
    public function phone_number(): HasOne
    {
        return $this->hasOne(PhoneNumber::class);
    }

    /**
     * @return HasOne
     */
    public function user_info(): HasOne
    {
        return $this->hasOne(UserInfo::class)->withDefault();
    }

    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return HasOne
     */
    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class);
    }

    /**
     * @return BelongsToMany
     */
    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class);
    }

    /**
     * @return BelongsToMany
     */
    public function committee_memberships(): BelongsToMany
    {
        return $this->belongsToMany(Committee::class)->withPivot('role');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'users';
    }

    public function keepDissociatedAttachments(): bool
    {
        return false;
    }

    public function getAttachmentAccessLevel(): string
    {
        return AccessLevelConstants::MEMBERS;
    }

    /**
     * Limit to current active role(s) for the given user.
     *
     * @return BelongsToMany
     */
    public function executive_roles(): BelongsToMany
    {
        return $this->belongsToMany(Executive::class);
    }

    /**
     * All historical executive roles of the given user.
     *
     * @return BelongsToMany
     */
    public function allExecutiveRoles(): BelongsToMany
    {
        return $this->belongsToMany(Executive::class, 'executive_user')
           ->withPivot('id', 'start_date', 'end_date', 'current');
    }

    /**
     * All historical executive roles of the given user.
     *
     * @return BelongsToMany
     */
    public function currentExecutiveRoles(): BelongsToMany
    {
        return $this->belongsToMany(Executive::class, 'executive_user')
            ->whereRaw('NOW() > start_date AND NOW() < end_date')
            ->withPivot('id', 'start_date', 'end_date', 'current');
    }
}
