<div>
<style>

</style>
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">GTech</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Gateway Account') }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ __('messages.Gateway Account') }}</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <a href="#" wire:click.prevent="openAddModal" class="btn btn-success waves-effect waves-light float-right mb-3">
                        <i class="fas fa-plus"></i> {{ __('messages.Add Gateway Account') }}
                    </a>
                    <table  class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>{{ __('messages.Order Id') }}</th>
                            <th>{{ __('messages.Gateway Account') }}</th>     {{-- For FC Department --}}
                            <th>{{ __('messages.Payment Method') }} </th>
                            <th>{{ __('messages.URL') }} </th>
                            <th>{{ __('messages.Created Time') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                            <th>{{ __('messages.Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($record as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->gateway_name ?? '' }}</td>
                            <td>{{ $row->payment_method ?? '' }}</td>
                            <td>{{ $row->website_url ?? '' }}</td>
                            <td> {{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
                            <td>
                                {{-- <label class="switch">
                                <input type="checkbox" class="toggle-status" data-id="{{ $row->id }}" {{ $row->status == 1 ? 'checked' : '' }}>
                                <span class="slider"></span>
                                </label> --}}
                                <label class="switch">
                                    <input type="checkbox" wire:click="toggleStatus({{ $row->id }})" {{ $row->status ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                 <button class="btn btn-primary"
                            wire:key="edit-{{ $row->id }}"
                            wire:click.prevent="editConfirmationFun({{ $row->id }})">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                                <button class="btn btn-danger waves-effect waves-light" wire:key="delete-{{ $row->id }}" wire:click.prevent="deleteConfirmationFun({{ $row->id }})">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td></td><td></td><td></td><td></td><td>Record not founds</td><td></td><td></td></td><td></td><td></td><td></td><td>
                        </tr>
                        @endforelse
                        
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <!-- end row -->
<!-- Modal -->
    @if($showModal)
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit Gateway Account' : 'Add Gateway Account' }}</h5>
                    <button type="button" class="close" wire:click="closeModal">×</button>
                </div>
                <form wire:submit.prevent="saveGatewayAccount">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Gateway Name</label>
                            <input type="text" class="form-control" wire:model="gateway_name">
                            @error('gateway_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="text" class="form-control" wire:model="website_url">
                            @error('website_url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            {{-- <input type="text" class="form-control" wire:model="payment_method"> --}}
                            <select wire:model="payment_method" class="form-control custom-select">
                                <option value="">--Select--</option>
                                <option value="QR">QR</option>
                                <option value="card">Card</option>
                            </select>
                            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ $isEditMode ? 'Update' : 'Save' }}</button>
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

<script>
    // FOR DELETE RECORD CODE START
        document.addEventListener('DOMContentLoaded', function () {
              window.addEventListener('show-delete-confirmation', event => {
                  Swal.fire({
                      title: "{{ __('messages.Are you sure you want to delete this record?') }}",
                      text: "{{ __('messages.If you delete this, it will be gone forever') }}!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "{{ __('messages.Yes') }}!",
                      cancelButtonText: "{{ __('messages.No') }}"
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (typeof Livewire !== 'undefined' && typeof Livewire.dispatch === 'function') {
                              Livewire.dispatch('callDeleteListner');
                          } else {
                              console.error('Livewire is not available or dispatch function is not defined.');
                          }
                      }
                  });
              });
          });
        window.addEventListener('ticketCancelled', event => {
          Swal.fire(
              "{{ __('messages.Done') }}!",
              "{{ __('messages.Successfully deleted') }}!",
              'success'
            )
        });
    // FOR DELETE RECORD CODE END
    // FOR CHANGE STATUS CODE START
        window.addEventListener('status-changed', event => {
            // Swal.fire({
            //     icon: 'success',
            //     title: event.message,
            //     timer: 1500,
            //     showConfirmButton: true
            // });
            Swal.fire(
                "{{ __('messages.Done') }}!",
                "{{ __('messages.Status Changed Successfully!') }}.",
                'success'
                )
        });
    // FOR CHANGE STATUS CODE END
    
</script>            

            
</div>
