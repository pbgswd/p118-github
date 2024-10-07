@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-edit"></i>', 'title' => $data["action"]. ' Member ' .
    ($data["action"] == "Edit" ? $data['user']->name : '') ])
@section('content')
<fieldset>
    <div class="row">
        <div class="border border-primary rounded border-3 mt-lg-2 p-2">
            <div class="col-lg-12">
                <h3>Membership</h3>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"> Seniority Number</span>
                </div>
                    <input type="text" class="form-control"  placeholder="Number"
                           name="user_membership[seniority_number]"
                           value="{{ old('user_membership.seniority_number',
                                        $data['user']->membership->seniority_number ?? '')}}" size="60" required/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"> Member Status</span>
                </div>
                <input type="text" class="form-control"  placeholder="Status" name="user_membership[status]"
                       value="{{ old('user_membership.status', $data['user']->membership->status ?? '')}}"
                       size="60" required/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"> Member Since</span>
                </div>
                <input
                    type="text"
                    class="form-control"
                    placeholder="yyyy-mm-dd"
                    name="user_membership[membership_date]"
                    value="{{ old('user_membership.membership_date',
                        \optional($data['user']->membership->membership_date ?? null)->toDateString() )  }}"
                    size="60"
                    required
                    data-provide="datepicker"
                    data-date-format="yyyy-mm-dd"/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Member Dues Status</span>
                </div>
                <input
                    type="text"
                    class="form-control"
                    placeholder="dues status, paid until date"
                    name="user_membership[membership_expires]"
                    value="{{ old('user_membership.membership_expires',
                        \optional($data['user']->membership->membership_expires ?? null)->toDateString())}}"
                    size="60"
                    required
                    data-provide="datepicker"
                    data-date-format="yyyy-mm-dd" />
            </div>
            <div class="col-lg-12 mt-1">
                <h4>
                    Admin notes (admin only)
                </h4>
            </div>
            <div class="col-lg-12">
                <textarea name="user_membership[admin_notes]" id="admin_notes" placeholder="Admin notes"
                          class="form-control" disabled>
                    {{old('user_membership.admin_notes', $data['user']->membership->admin_notes ?? '')}}
                </textarea>
            </div>
         </div>
    </div>
</fieldset>
@endsection
