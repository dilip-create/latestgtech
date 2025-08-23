<div>
    <form wire:submit.prevent="save">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parameter Name</th>
                    <th>Parameter Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $index => $row)
                <tr>
                    <td>
                        <input type="text" wire:model="rows.{{ $index }}.parameter_name" class="form-control" placeholder="Parameter Name">
                    </td>
                    <td>
                        <input type="text" wire:model="rows.{{ $index }}.parameter_value" class="form-control" placeholder="Parameter Value">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" wire:click="removeRow({{ $index }})">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" wire:click="addRow">Add Row</button>
        <button type="submit" class="btn btn-success">Save</button>
    </form>

    @if(session()->has('message'))
        <div class="alert alert-success mt-2">{{ session('message') }}</div>
    @endif
</div>
