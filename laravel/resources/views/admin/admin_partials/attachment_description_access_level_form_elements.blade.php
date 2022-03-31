<div class="row">
    <div class="col-12 mt-3">
        <h5>Description</h5>
        <input type="text" class="form-control"  placeholder="Add a description for this file"
               name="attachment[description]" value="{{old('attachment.description',
               $data['attachment']->description)}}" size="40"/>
    </div>
    <div class="col-12 mt-3">
        Access Level for attachment:
        <div class="form-group">
            {{ select_options($data['access_levels'], old('attachment.access_level',
                $data['attachment']->access_level), ['name' => 'attachment[access_level]',
                'class' => 'form-control', 'placeholder' => 'Access Level'], 'required') }}
        </div>
    </div>
</div>
