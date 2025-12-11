<div x-data="{ imagePreview: null }" x-init="() => { $watch('image', value => imagePreview = value ? URL.createObjectURL(value) : null) }">
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="flex flex-col gap-2">
        <input wire:model="name" type="text" placeholder="Name" class="input w-full" />
        @error('name')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <select wire:model="brandId" class="select w-full">
            <option value="">Select Brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
        @error('brandId')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="image" type="file" class="input w-full" accept="image/*" />
        @if ($image)
            <img x-bind:src="imagePreview" width="100" class="mt-2">
        @elseif ($oldImage)
            <img src="{{ asset('storage/' . $oldImage) }}" width="100" class="mt-2">
        @else
            <img src="https://via.placeholder.com/100" width="100" class="mt-2">
        @endif
        @error('image')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="code" type="text" placeholder="Product Code" class="input w-full" />
        @error('code')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <input wire:model="sensor_type" type="text" placeholder="Sensor Type" class="input w-full" />
        <input wire:model="sensor_size" type="text" placeholder="Sensor Size" class="input w-full" />
        <input wire:model="resolution" type="text" placeholder="Resolution" class="input w-full" />
        <input wire:model="weight" type="text" placeholder="Weight" class="input w-full" />
        <input wire:model="battery" type="text" placeholder="Battery" class="input w-full" />
        <textarea wire:model="description" placeholder="Description" class="textarea w-full"></textarea>

        <div class="flex justify-between">
            <button type="button" wire:click="resetForm" class="btn btn-error">Reset</button>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </div>

        @if (session()->has('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="text-red-600">{{ session('error') }}</div>
        @endif
    </form>
</div>
