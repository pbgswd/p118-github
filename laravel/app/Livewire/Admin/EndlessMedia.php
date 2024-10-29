<?php

namespace App\Livewire\Admin;

use App\Models\Attachment;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class EndlessMedia extends Component
{

    public $perPage = 10;

    public function render()
    {
        $attachments = Attachment::with('user')->orderBy('id', 'ASC')->paginate($this->perPage);
        $attachments->each(function ($item) {
            //todo have a thumb size for every image asset
            $item->file_type = File::extension('storage/'.$item->subfolder.'/'.$item->file);
            $item->file_size = round(File::size('storage/'.$item->subfolder.'/'.$item->file) / 1024, 2);
        });
        return view('livewire.admin.endless-media', ['attachments' => $attachments]);
    }
    public function loadMore()
    {
        $this->perPage += 10;
    }
}
