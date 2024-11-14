<?php

namespace App\Livewire\Admin;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Livewire\Component;

class EndlessMedia extends Component
{

    public $perPage = 1000;

    public function render(): View
    {
        $attachments = Attachment::query()->with('user')->where('file_type', 'image')
            ->with(['venue' => function ($query) {
                $query->select('file_name', 'image AS file', DB::raw("'venues' as subfolder"))->whereNotNull('image');
            }])
            ->paginate($this->perPage);
        $attachments->each(function ($item) {
            //todo have a thumb size for every image asset
            $item->file_size =
                round(File::size('storage/'.$item->subfolder.'/'.$item->file) /
                    1024, 2);
        });
dd($attachments);
        $data['attachments'] = $attachments;

        return view('livewire.admin.endless-media', ['data' => $data]);
    }
    public function loadMore()
    {
        $this->perPage += 10;
    }
}
