<div>
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">GTech</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Parameter Details') }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ __('messages.Parameter Details') }}</h4>
                </div>
            </div>
        </div>     
    <!-- end page title --> 
    <div class="card">
        <div class="card-body">
            <h3>{{ __('messages.Gateway') }} : <span class="text text-success">{{$gatewayDetails->gatewayAccount->gateway_name}}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('messages.Payment Channel') }}  :  <span class="text text-success">{{ucfirst($gatewayDetails->channel_name)}}</span></h3>
            <form wire:submit.prevent="save">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('messages.Parameter Name') }}</th>
                            <th>{{ __('messages.Parameter Value') }}</th>
                            <th>{{ __('messages.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $index => $row)
                        <tr>
                            <td>
                                <input type="text" wire:model="rows.{{ $index }}.parameter_name" class="form-control" placeholder="{{ __('messages.Name') }}">
                            </td>
                            <td>
                                <input type="text" wire:model="rows.{{ $index }}.parameter_value" class="form-control" placeholder="{{ __('messages.Value') }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" wire:click="removeRow({{ $index }})">{{ __('messages.Remove') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary" wire:click="addRow">{{ __('messages.Add Row') }}</button>
                <button type="submit" class="btn btn-success">{{ __('messages.Save') }}</button>
                <a href="{{ route('channel.parameter.list') }}" wire:navigate>
                    <button class="btn btn-dark"><i class="mdi mdi-chevron-triple-left"></i>{{ __('messages.Back') }}</button>
                </a>
            </form>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success mt-2">{{ session('message') }}</div>
    @endif
</div>
