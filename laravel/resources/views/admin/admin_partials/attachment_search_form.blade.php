<div class="row mt-2 mb-2">
    <form id="search-form" action="{{ route('list_attachments_search_result') }}" method="POST">
        @csrf
        <div class="col-12">
            <div class="form-group">
                <input class="form-control form-control-dark w-100" type="text" name="search"
                       style="background-color:#aaaaaa;" placeholder="Attachment Search" aria-label="Search" size="80">
            </div>
        </div>
    </form>
</div>
