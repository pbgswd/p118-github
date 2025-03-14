<?php

namespace App\Models;

use App\Policies\FaqPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property string $access_level
 * @property bool $live
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @method static withoutGlobalScopes()
 */
class FaqData extends LiveableModel implements Searchable
{
    use HasFactory;
    use Sortable;

    protected $guard_name = 'web';

    protected $table = 'faqs_data';

    protected $policies = [
        self::class => FaqPolicy::class,
    ];

    public $fillable = [
        'question',
        'answer',
        'live',
        'access_level',
        'sort_order',
    ];

    public $sortable = [
        'question',
        'answer',
        'live',
        'access_level',
        'sort_order',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'live' => 'boolean',
        ];
    }

    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }

    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('FaqData');

        $data = FaqData::with('faq')->where('id', $this->faq_id)->get()
            ->pluck('faq.slug', 'faq_id');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->answer,
                \route('admin_faq_edit', $this->question)
            );
        }

        return new SearchResult(
            $this,
            $this->answer,
            \route('faq_show', $data->all())
        );
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
