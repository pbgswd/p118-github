<?php

namespace App\Models;

use App\Policies\AgreementPolicy;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property string $access_level
 * @property boolean $live
 * @property User $users
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime from
 * @property \DateTime until
 */

class Agreement extends Model
{
    use Sortable;

    /**
     * @var array
     */
    protected $policies = [
        Agreement::class => AgreementPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'access_level',
        'live',
        'sort_order',
        'from',
        'until'
        ];

    protected $dates =
        [
            'from',
            'until',
            'created_at',
            'updated_at',
        ];

    protected $casts =
        [
            'live' => 'boolean',
        ];

    public function users()
    {
        return $this->hasOne(User::class);
    }

}
