<form method="post" name="message_preferences_edit" action="#" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    <div class="row pt-2">
        <div class="col-12 mb-3">
            <h3 class="">
                <i class="far fa-envelope-open"></i>
                Message Preferences
            </h3>
            <h5>
                Modify your preferences for email messages sent to you from IATSE Local 118.
            </h5>
        </div>
        <div class="row m-3 p-4 border border-1 rounded">
            <div class="col-sm-12 col-md-6">
                <h2>Message frequency preferences</h2>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Send them right away, as messages are sent out
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        Daily compilation, all messages for that day in one email.
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                    <label class="form-check-label" for="exampleRadios3">
                        Weekly Digest, all messages for that week in one email.
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                    <label class="form-check-label" for="exampleRadios4">
                        Unsubscribe, I will check the Messages archive on the website instead.
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <h2>Topic Preferences</h2>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[meetings]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Notice of Meetings" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[news]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="News and Information" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[jobs]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Work Postings" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[ywc]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Young Workers Committee" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[womens]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Women's Committee" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[pride]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Pride Committee" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[training]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Training Committee" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[arc]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Anti-Racism Committee" aria-label="Text input with checkbox">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[safety]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Safety Committee" aria-label="Text input with checkbox">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[organizing]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control"  value="Organizing Committee" aria-label="Text input with checkbox">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="list_selection[wardrobe]" type="checkbox" value="1" aria-label="Checkbox for following text input" readonly>
                    </div>
                    <input type="text" class="form-control" value="Wardrobe, Wig and Make-Up Committee"  aria-label="Text input with checkbox">
                </div>
            </div>


            <div class="col-12 mt-2 mb-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="Update Message Prefences" />
            </div>
        </div>

    </div>
</form>

