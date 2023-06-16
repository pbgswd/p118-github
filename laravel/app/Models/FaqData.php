<?php

namespace App\Models;

use App\Policies\FaqPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Constants\AccessLevelConstants;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int          $id
 * @property string       $question
 * @property string       $answer
 * @property string       $access_level
 * @property bool         $live
 * @property DateTime     $created_at
 * @property DateTime     $updated_at
 * @method static withoutGlobalScopes()
 */


class FaqData extends LiveableModel implements Searchable
{
    use Sortable;
    use HasFactory;

    protected $guard_name = 'web';
    protected $table = 'faqs_data';

    protected $policies = [
        self::class => FaqPolicy::class,
    ];

    public $fillable = [
        'question',
        'answer',
        'live',
        'access_level'
    ];

    public $sortable = [
        'question',
        'answer',
        'live',
        'access_level',
        'created_at',
        'updated_at',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public $casts = [
        'live' => 'boolean',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $modelList = new ModelList;
        $this->info = $modelList->getModelInfo('FaqData');

        if (request()->route()->getName() == 'admin_search') {
            return new SearchResult(
                $this,
                $this->title,
                \route('admin_faq_edit', $this->id)
            );
        }

        return new SearchResult(
            $this,
            $this->title,
            \route('faq_show', $this->id)
        );
    }

}
