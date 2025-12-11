<div x-data="{ brandId: @entangle('brandId'), name: @entangle('name') }">
    <div class="flex justify-between mb-3">
        <select wire:model.live="limit" class="select w-fit">
            <option value="1">1 record</option>
            <option value="5">5 records</option>
            <option value="10">10 records</option>
            <option value="20">20 records</option>
        </select>

        <label class="input">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                    stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </g>
            </svg>
            <input wire:model.live.debounce.500ms="search" type="search" class="grow" placeholder="Search" />
        </label>
    </div>

    <table class="table table-zebra border border-gray-200">
        <tr>
            <th>STT</th>
            <th>Name</th>

        </tr>
        @foreach ($brands as $row)
            <tr wire:key="{{ $row->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>
                    <button wire:click="deleteBrand('{{ $row->id }}')"
                        wire:confirm="Do you want to delete - {{ $row->name }} ?"
                        class="btn btn-sm btn-soft btn-error">Delete
                    </button>
                    <button x-on:click="brandId='{{ $row->id }}', name='{{ $row->name }}';editModal.showModal()"
                        class="btn btn-sm btn-soft btn-warning">Edit</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div>
        {{ $brands->links() }}
    </div>
    <dialog id="editModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold my-3">Update brand</h3>
            <div>
                <form wire:submit="updateBrand" class="flex flex-col gap-2">
                    <input x-model="brandId" hidden type="text" class="input w-full" />
                    <input x-model="name" type="text" placeholder="Name brand" class="input w-full" />

                    <div class="flex justify-between">
                        <button x-on:click="editModal.close()" type="button"
                            class="btn btn-soft btn-error">Cancel</button>
                        <button x-on:click="editModal.close()" class="btn btn-soft btn-primary w-fit"
                            type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
</div>
