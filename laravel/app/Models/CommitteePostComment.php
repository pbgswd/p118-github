<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property int $committee_id
 * @property int $user_id
 * @property int $post_id
 * @property int $parent_id
 * @property string $content
 * @property bool $live
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property User $comment_author
 * @property CommitteePost $committee_post
 * @property Committee $committee
 *
 * @method static withoutGlobalScopes()
 */
class CommitteePostComment extends LiveableModel implements Searchable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use Sortable;

    protected $guard_name = 'web';

    protected $policies = [
        // Committee::class=>CommitteePolicy::class,
    ];

    public $sortable = [
        'id',
        'content',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content',
        'live',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'live' => 'boolean',
        ];
    }

    public function getSearchResult(): SearchResult
    {
        $committee = Committee::where('id', $this->committee_id)->first('slug');
        $committeePost = CommitteePost::where('id', $this->post_id)->first();

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $committeePost->title,
                \route('admin_committee_post_edit', [$committee->slug, $committeePost->slug])
            );
        }

        return new SearchResult(
            $this,
            $this->content,
            \route('public_committee_post_show', [$committee->slug, $committeePost->slug])
        );
    }

    public function comment_author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function committee_post(): HasOne
    {
        return $this->hasOne(CommitteePost::class, 'id', 'post_id');
    }

    public function committee(): HasOne
    {
        return $this->hasOne(Committee::class, 'id', 'committee_id');
    }
}
