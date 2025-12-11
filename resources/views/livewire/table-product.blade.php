<div x-data="{ productId: @entangle('productId'), name: @entangle('name'), brandId: @entangle('brandId'), image: @entangle('image'), code: @entangle('code'), sensor_type: @entangle('sensor_type'), sensor_size: @entangle('sensor_size'), resolution: @entangle('resolution'), weight: @entangle('weight'), battery: @entangle('battery'), description: @entangle('description') }">
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
            <th>Brand ID</th>
            <th>Image</th>
            <th>Code</th>
            <th>Sensor Type</th>
            <th>Sensor Size</th>
            <th>Resolution</th>
            <th>Weight(g)</th>
            <th>Battery</th>
            <th>Description</th>
        </tr>
        @foreach ($products as $row)
            <tr wire:key="{{ $row->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->brand_id }}</td>
                <td>
                    @if ($row->image)
                        <img src="{{ asset('storage/' . $row->image) }}" alt="{{ $row->name }}" width="50">
                    @else
                        No image
                    @endif
                </td>
                <td>{{ $row->code }}</td>
                <td>{{ $row->sensor_type }}</td>
                <td>{{ $row->sensor_size }}</td>
                <td>{{ $row->resolution }}</td>
                <td>{{ $row->weight }}</td>
                <td>{{ $row->battery }}</td>
                <td>{{ $row->description }}</td>
                <td>
                    <button wire:click="deleteProduct('{{ $row->id }}')"
                        wire:confirm="Do you want to delete - {{ $row->name }} ?"
                        class="btn btn-sm btn-soft btn-error">Delete</button>
                    <button
                        x-on:click="productId='{{ $row->id }}', name='{{ $row->name }}',
                         brandId='{{ $row->brand_id }}',
                         image='{{ $row->image ?? '' }}',
                         code='{{ $row->code }}',
                         sensor_type='{{ $row->sensor_type }}',
                         sensor_size='{{ $row->sensor_size }}',
                         resolution='{{ $row->resolution }}',
                         weight='{{ $row->weight }}',
                         battery='{{ $row->battery }}',
                         description='{{ $row->description }}';editModal.showModal()"
                        class="btn btn-sm btn-soft btn-warning">Edit</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div>
        {{ $products->links() }}
    </div>

    <dialog id="editModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold my-3">Update product</h3>
            <div>
                <form wire:submit="updateProduct" class="flex flex-col gap-2">
                    <input x-model="productId" hidden type="text" class="input w-full" />
                    <input x-model="name" type="text" placeholder="Name product" class="input w-full" />
                    <select wire:model="brandId" class="select w-full">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        <input wire:model="image" type="file" accept="image/*" class="input w-full" />

                        <div class="mt-2">
                            @if ($image instanceof \Livewire\TemporaryUploadedFile)
                                <img src="{{ $image->temporaryUrl() }}" width="100" />
                            @elseif ($productId && ($product = \App\Models\Product::find($productId)) && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="100" />
                            @else
                                <img src="https://via.placeholder.com/100" width="100" />
                            @endif
                        </div>

                    </div>

                    <input x-model="code" type="text" placeholder="Code" class="input w-full" />
                    <input x-model="sensor_type" type="text" placeholder="Sensor Type" class="input w-full" />
                    <input x-model="sensor_size" type="text" placeholder="Sensor Size" class="input w-full" />
                    <input x-model="resolution" type="text" placeholder="Resolution" class="input w-full" />
                    <input x-model="weight" type="text" placeholder="Weight" class="input w-full" />
                    <input x-model="battery" type="text" placeholder="Battery" class="input w-full" />
                    <input x-model="description" type="text" placeholder="Description" class="input w-full" />
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
