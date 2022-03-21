<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use App\Services\AttachmentService;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Attachment.
 *
 * @property int       $id
 * @property string    $file
 * @property string    $file_name
 * @property string    $subfolder
 * @property string    $description
 * @property string    $access_level
 * @property User      $user
 * @property Meeting[] $meetings
 * @property DateTime  $created_at
 * @property DateTime  $updated_at
 */
class Attachment extends Model implements Searchable
{
    use Sortable;

    /** @var string */
    public $path_info;

    /** @var string */
    public $extension;

    /** @var string */
    public $imagedata;

    /** @var string */
    public $filesize;

    /** @var string */
    protected $guard_name = 'web';

    /** @var array */
    protected $policies = [
        self::class => AttachmentPolicy::class,
    ];

    public $sortable = [
        'id',
        'file_name',
        'access_level',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
        'file_name',
        'subfolder',
        'description',
        'access_level',
    ];

    /** @var array */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this->setCalculatedProperties(),
            $this->file_name,
            \route('admin_attachment_edit', $this->id)
        );
    }

    /**
     * @return $this
     */
    public function setCalculatedProperties(): self
    {
        $this->path_info = \pathinfo(\storage_path('app/'.$this->subfolder).'/'.$this->file);
        $this->extension = $this->path_info['extension'];
        $this->imagedata = \getimagesize(\storage_path('app/'.$this->subfolder).'/'.$this->file);
        $this->filesize = AttachmentService::human_filesize(\filesize(\storage_path('app/'.$this->subfolder).'/'.
            $this->file));

        return $this;
    }

    /**
     * @return BelongsToMany
     */
    public function meetings(): BelongsToMany
    {
        return $this->belongsToMany(Meeting::class, 'attachment_meeting');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
