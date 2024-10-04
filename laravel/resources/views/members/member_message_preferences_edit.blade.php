<form method="post" name="message_preferences_edit" action="{{route('update_message_preferences', Auth::user())}}"
      enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-12 my-6 py-2 text-center align-content-center">
            <h2><i class="far fa-envelope-open"></i> Message Preferences</h2>
            <h5>Modify your preferences for email messages sent to you from IATSE Local 118.</h5>
            <h3><a class="btn btn-outline-primary" href="{{route('messages')}}">Messages Previously Sent</a></h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-12 col-md-6 pt-4 px-4">
            <h2>Message frequency preferences</h2>
            <p>The Local sends out 5-10 messages per week to members.</p>
            <p>Choose how often you want to receive messages.</p>
            @foreach($data['message_frequency_preference_options'] as $k => $v )
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="preference" id="exampleRadios1"
                           value="{{$k}}"
                           {{ old('message.preference', $data['user']['message_frequency_preferences']['preference'] == $k ? 'checked' : '')}}
                           @if($data['user']['message_frequency_preferences']['preference'] == '' and $k == 'now') checked @endif >
                    <label class="form-check-label" for="exampleRadios1">
                        {{$v}}
                    </label>
                    <input type="hidden" name="message[frequency][{{$k}}]" value="0"/>
                </div>
            @endforeach
            <div x-data="TopicSelect()" class="col pt-4">
                <h2>Topic Preferences</h2>
                <p>Get messages for select topics</p>
                @foreach($data['topic_subscription_options'] as $topic)
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input x-bind:checked="" class="form-check-input mt-0"
                                   id="checkbox-topic-{{$topic['slug']}}" name="message_selections[topic][]"
                                   type="checkbox"
                                   value="{{$topic['slug']}}" aria-label="Checkbox for following text input" readonly
                                   @if(array_key_exists($topic['slug'], $data['selections']['topics']))
                                       checked
                                @endif
                            >
                        </div>
                        <input type="text" class="form-control" value="{{$topic['name']}}"
                               aria-label="Text input with checkbox">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-12 col-md-6 pt-4 px-4">
            <div x-data="ModelSelect()" class="col">
                <h2>Content Sections</h2>
                <p>Get messages from different sections of the website.</p>
                @foreach($data['model_subscription_options'] as $mso)
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input x-bind:checked="" class="form-check-input mt-0" id="checkbox-model-{{$mso['model']}}"
                                   name="message_selections[model][]"
                                   type="checkbox" value="{{$mso['model']}}"
                                   aria-label="Checkbox for following text input"
                                {{array_key_exists($mso['model'], $data['selections']['models']) ? 'checked' : ''}}
                            >
                        </div>
                        <input type="text" class="form-control" value="{{$mso['name']}} - {{$mso['description']}}"
                               aria-label="Text input with checkbox">
                    </div>
                @endforeach
            </div>
            <div x-data="CommitteeSelect()" class="col mt-6 pt-4">
                <h2>Committees</h2>
                <p>Get messages from select committees.</p>
                @foreach($data['committees'] as $comm)
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input x-bind:checked="" class="form-check-input mt-0"
                                   id="checkbox-committee-{{$comm['slug']}}" name="message_selections[committee][]"
                                   type="checkbox" value="{{$comm['slug']}}"
                                   aria-label="Checkbox for following text input" readonly
                                {{array_key_exists($comm['slug'], $data['selections']['committees']) ? 'checked' : ''}}
                            >
                        </div>
                        <input type="text" class="form-control" value="{{$comm['name']}}"
                               aria-label="Text input with checkbox">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 my-5 text-center">
            <i class="fas fa-edit fa-2x"></i>
            <input class="btn btn-outline-primary" type="submit" value="Update Message Prefences"/>
        </div>
    </div>
</form>
<script>
    function TopicSelect() {
        return {
            selectalltopic: false,
        };
    }

    function ModelSelect() {
        return {
            selectallmodel: false,
        };
    }

    function CommitteeSelect() {
        return {
            selectallcommittee: false,
        };
    }
</script>
