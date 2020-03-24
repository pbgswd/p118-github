<?php

namespace App\Models;

use App\Models\Interfaces\HasAttachment;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\SearchResult;
use Spatie\Searchable\Searchable;


/**
 * Class User
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
 * @property Committee[]   $committee_membership
 */
class User extends Authenticatable implements HasAttachment, Searchable
{
    use Notifiable;
    use Sortable;
    use HasRoles;

    protected $guard_name = 'web';

    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public $sortable = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
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
        return new SearchResult(
            $this,
            $this->name,
            \route('member', $this->id),
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
        return $this->hasOne(UserInfo::class);
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
    public function committee_membership(): BelongsToMany
    {
        //TODO: pluralize method name
        return $this->belongsToMany(Committee::class)->withPivot('role');
    }

    /**
     * @return string
     */
    public function getAttachmentFolder(): string
    {
        return 'users';
    }

}
