<!--suppress ALL -->
<div>
    <div class="row">
    @foreach($data['attachments'] as $attachment)

        <div class="col-sm-12 col-md-3 m-2 p-4 text-wrap text-break border border-secondary">
            {{$attachment->file_name}}
            <a href="#" data-bs-toggle="Insert {{$attachment->file_name}} into content"
               title="Click to insert {{ $attachment->file_name }} into the content">
                <img src="/storage/{{$attachment->subfolder}}/{{$attachment->file}}" class=" mt-2 w-100"
                     @click="insertImage('<img src=\'/storage/{{$attachment->subfolder}}/{{$attachment->file}}\' alt=\'{{ $attachment->file_name }}\' />')"/>
            </a>
            <div class="row text-break">
                {{$attachment->access_level}}, {{ $attachment->file_type}}, {{$attachment->file_extension}}<br />
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
    @if($data['attachments']->hasMorePages())
        <button wire:click.prevent="loadMore">Load more</button>
    @endif
</div>
