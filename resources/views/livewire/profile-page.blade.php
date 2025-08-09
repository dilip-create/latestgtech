<div>
<div class="row mt-5">
    <div class="col-lg-12">
        <div id="merchant-agent" style="font-size:12px;">
                    <div class="table-responsive">
                        <table class="table dashboard" style="color:#fff;">
                            <tbody>
                                <tr>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{ trans('messages.User Name') }}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ Session::get('auth')->user_name ?? '' }}</td>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{ trans('messages.Created Date/Time') }}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ Session::get('auth')->created_at->format('Y-m-d H:i:s') ?? '' }}</td>
                                </tr>
                                @if (Session::get('auth')->role_name == 'Merchant')
                                <tr>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Merchant Code')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $merchantData->merchant_code ?? '' }}</td>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Merchant Name')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $merchantData->merchant_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Agent Code')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $agentData->agent_code ?? '' }}</td>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Agent Name')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $agentData->agent_name ?? '' }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Agent Code')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $agentData->agent_code ?? '' }}</td>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Agent Name')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ $agentData->agent_name ?? '' }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Email')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ Session::get('auth')->email ?? '' }}</td>
                                    <td style="width: 25%; background-color:#808080; border: 1px solid lightgray" class="header-title">{{__('messages.Mobile Number')}}</td>
                                    <td style="width: 25%; color:#000; border: 1px solid lightgray" class="header-title">{{ Session::get('auth')->mobile_number ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
        
    </div>
 </div>
<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card-box mt-5">
          
                    <div class="mt-4 mt-lg-0">
                        <h4 class="header-title">Horizontal Form</h4>
                        <p class="sub-header">
                            Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                        </p>

                    
                        <form role="form" class="parsley-examples" data-parsley-validate novalidate>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-md-4 col-form-label">Email<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" required parsley-type="email" class="form-control"
                                            id="inputEmail3" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hori-pass1" class="col-md-4 col-form-label">Password<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input id="hori-pass1" type="password" placeholder="Password" required
                                            class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hori-pass2" class="col-md-4 col-form-label">Confirm Password
                                    <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input data-parsley-equalto="#hori-pass1" type="password" required
                                            placeholder="Password" class="form-control" id="hori-pass2">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-md-4 form-control-label">Web Site<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="url" required parsley-type="url" class="form-control"
                                            id="webSite" placeholder="URL">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <div class="checkbox">
                                        <input id="remember-2" type="checkbox">
                                        <label for="remember-2"> Remember me </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                        Register
                                    </button>
                                    <button type="reset"
                                            class="btn btn-secondary waves-effect">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

            <!-- end row -->
        </div>
    </div><!-- end col-->
</div>
<!-- end row -->
</div>