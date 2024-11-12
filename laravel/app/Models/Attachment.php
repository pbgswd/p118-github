<?php

namespace App\Models;

use App\Policies\AttachmentPolicy;
use App\Services\AttachmentService;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * Class Attachment.
 *
 * @property int $id
 * @property string $file
 * @property string $file_name
 * @property string $subfolder
 * @property string $description
 * @property string $access_level
 * @property User $user
 * @property Meeting[] $meetings
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Attachment extends Model implements Searchable
{
    use HasFactory;
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
        'file_type',
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
        'file_type',
        'subfolder',
        'description',
        'access_level',
    ];

    /** @var array */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this->setCalculatedProperties(),
            $this->file_name,
            \route('admin_attachment_edit', $this->id)
        );
    }

    public function setFileAttribute($value): void
    {
        $fileTypes = [
            'pdf' => 'pdf',
            'zip' => 'zip',
            'bin' => 'binary',
        ];
        if(!$this->attributes['subfolder']) {
           throw new \Exception('file subfolder not set');
        }
        $file_extension = strtolower(File::extension('storage/' . $this->attributes['subfolder'] . '/' . $value));

        $this->file_type = $fileTypes[$file_extension] ?? (
            in_array($file_extension,['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file');
        $this->attributes['file'] = $value;
    }


    public function setCalculatedProperties(): self
    {
        $this->path_info = \pathinfo(\storage_path('app/'.$this->subfolder).'/'.$this->file);
        $this->extension = $this->path_info['extension'];

        if (file_exists($this->path_info['dirname'].'/'.$this->path_info['basename'])) {
            $this->imagedata = \getimagesize(\storage_path('app/'.$this->subfolder).'/'.$this->file);
            $this->filesize = AttachmentService::human_filesize(\filesize(\storage_path('app/'.$this->subfolder)
                .'/'.$this->file));

        } else {
            $this->imagedata = [0, 0, 0, '"width="0" height="0"', 'bits' => 8, 'mime' => '"application/octet-stream"'];
            $this->filesize = '0KB';
        }

        return $this;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
