<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use App\Services\AttachmentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @property int       $id
 * @property string    $file
 * @property string    $file_name
 * @property string    $subfolder
 * @property User      $user
 * @property Meeting[] $meetings
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Attachment extends Model implements Searchable
{
    /** @var string */
    public $path_info;

    /** @var string */
    public $extension;

    /** @var string */
    public $imagedata;

    /** @var string */
    public $filesize;

    protected $guard_name = 'web';

    protected $policies = [
        Attachment::class => AttachmentPolicy::class,
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'file',
        'file_name',
        'subfolder',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $this->path_info = pathinfo(storage_path('app/' . $this->subfolder) . '/' . $this->file);
        $this->extension = $this->path_info['extension'];
        $this->imagedata = getimagesize(storage_path('app/' . $this->subfolder) . '/' . $this->file);
        $this->filesize =  AttachmentService::human_filesize(filesize(storage_path('app/' . $this->subfolder) . '/' . $this->file));

        return new SearchResult(
            $this,
            $this->file_name,
            \route('admin_attachment_edit', $this->id),
        );
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
