@extends('back.layout.auth-layout')
@section('pageTitle', $pageTitle ?? 'Page Title Here')
@section('content')
    <div class="register-box bg-white box-shadow border-radius-10">
        <div class="wizard-content">
            <form class="tab-wizard2 wizard-circle wizard clearfix" role="application" id="steps-uid-0">
                <div class="content clearfix">
                    <h5 id="steps-uid-0-h-0" tabindex="-1" class="title current">Basic Account Credentials</h5>
                    <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current"
                        aria-hidden="false">
                        <div class="form-wrap max-width-600 mx-auto">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Email Address*</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Username*</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Password*</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Confirm Password*</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="actions clearfix">
                    <ul role="menu" aria-label="Pagination">
                        <li style="display: none;" aria-hidden="true"><a href="#finish" role="menuitem">Submit</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
@endsection
