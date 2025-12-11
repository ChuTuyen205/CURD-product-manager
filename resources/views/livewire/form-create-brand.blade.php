<div>
    <form wire:submit="save" class="flex flex-col gap-2">
        <input wire:model="name" type="text" placeholder="Brand Name" class="input w-full" />
        <div>
            <button type="reset" class="btn btn-soft btn-error">Reset</button>
            <button class="btn btn-soft btn-primary w-fit" type="submit">Add brand</button>
        </div>
    </form>
</div>
