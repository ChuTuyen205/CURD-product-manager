<?php
namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class FormCreateBrand extends Component
{
    public $name;

    public function save()
    {
        Brand::query()->create(
            [
                'name' => $this->name,

            ]
        );
        flash()->success('Tạo thành công!');
        # Bắn thêm 1 bản tin -> đã tạo thành công
        $this->dispatch('brand-created');
    }

    public function render()
    {
        return view('livewire.form-create-brand');
    }
}
