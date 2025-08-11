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
                                @elseif (Session::get('auth')->role_name == 'Agent')
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
    <div class="col-lg-4 offset-lg-4">
        <div class="card-box mt-5">
          
                    <div class="mt-4 mt-lg-0">
                        <h4 class="header-title">{{__('messages.Change Password')}}</h4>
                        {{-- <p class="sub-header">
                            Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                        </p> --}}
                        <form wire:submit.prevent="changePass" method="POST" class="mt-2" role="form" class="parsley-examples" data-parsley-validate novalidate>
                        @csrf
                            <div class="form-group row">
                                <label for="NewPassword" class="col-md-4 col-form-label">{{__('messages.New Password')}}<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control @error('NewPassword') is-invalid @enderror" wire:model.live="NewPassword" placeholder="{{__('messages.Enter here')}}">
                                    @error('NewPassword')
                                    <label class="error" for="NewPassword">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmPassword" class="col-md-4 col-form-label">{{__('messages.Confirm Password')}}<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror" wire:model.live="confirmPassword" placeholder="{{__('messages.Enter here')}}">
                                    @error('confirmPassword')
                                    <label class="error" for="confirmPassword">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="oldPassword" class="col-md-4 col-form-label">{{__('messages.Old Password')}}<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" wire:model.live="oldPassword" placeholder="{{__('messages.Enter here')}}">
                                    @error('oldPassword')
                                    <label class="error" for="oldPassword">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">{{__('messages.Save')}}</button>
                                    <button type="reset" class="btn btn-secondary waves-effect">{{__('messages.Reset')}}</button>
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