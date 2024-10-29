<!--suppress ALL -->
<div>
    <div class="row">
    @foreach($attachments as $attachment)
        <div class="col-sm-12 col-md-3 m-2 p-4 text-wrap text-break border border-secondary">
            @if(in_array($attachment->file_type, ['pdf','xls','xlsx', 'txt',]))
                <div class="col-12 text-center mb-3">
                    <i class="bi bi-filetype-{{$attachment->file_type}} fs-1"></i>
                </div>
            @endif
            @if(in_array($attachment->file_type, ['doc','docx']))
               <div class="col-12 text-center mb-3">
                    <i class="bi bi-file-word fs-1"></i>
               </div>
            @endif

            @if($attachment->file_type == 'bin')
               <div class="col-12 text-center mb-3">
                    <i class="bi bi-file-binary"></i>
               </div>
            @endif

            @if($attachment->file_type == 'zip')
               <div class="col-12 text-center mb-3">
                    <i class="bi bi-file-zip"></i>
               </div>
            @endif

            {{$attachment->file_name}}

                @if(in_array(strtolower($attachment->file_type), ['jpg','jpeg','png','gif','webp', 'svg']))
                    <a href="#" data-bs-toggle="Insert {{$attachment->file_name}} into content"
                       title="Click to insert {{ $attachment->file_name }} into the content">
                        <img src="/storage/{{$attachment->subfolder}}/{{$attachment->file}}" class=" mt-2 w-100"
                             @click="insertImage('<img src=\'/storage/{{$attachment->subfolder}}/{{$attachment->file}}\' alt=\'{{ $attachment->file_name }}\' />')"/>
                    </a>
                @endif




                <div class="row text-break">
                    {{$attachment->access_level}}, {{ $attachment->file_type}}, <br />
                    {{$attachment->file_size}} Kb <br />
                    <a href="{{ route('admin_attachment_edit', $attachment->id) }}" title="Edit {{ $attachment->file_name }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
        </div>
    @endforeach
    </div>
        <div
            x-data="{
        observe () {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        @this.call('loadMore')
                    }
                })
            }, {
                root: null
            })

            observer.observe(this.$el)
        }
    }"
            x-init="observe"
        ></div>
    @if($attachments->hasMorePages())
        <button wire:click.prevent="loadMore">Load more</button>
    @endif
</div>
