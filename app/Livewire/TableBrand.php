<?php
namespace App\Livewire;

use App\Models\Brand;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TableBrand extends Component
{
    use WithPagination;

    public $limit  = 10;
    public $search = '';

    # Form update
    public $brandId;
    public $name;

    public function deleteBrand($brandId)
    {
        try {
            $brand = Brand::query()->findOrFail($brandId);
            $brand->delete();
            flash()->success('Xoá thành công!');
        } catch (\Exception $e) {
            flash()->error('Xoá thất bại!');
        }
    }

    public function updateBrand()
    {
        try {
            $brand       = Brand::query()->findOrFail($this->brandId);
            $brand->name = $this->name;
            $brand->save();
            flash()->success('Cập nhật thành công!');
        } catch (\Exception $e) {
            flash()->error('Cập nhật thất bại!');
        }
    }

    #[On('contact-created')]
    public function render()
    {
        if (empty($this->search)) {
            $brands = Brand::query()->paginate($this->limit);
        } else {
            # Reset page
            $this->resetPage();
            $brands = Brand::query()
                ->where('name', 'like', "%{$this->search}%")
                ->paginate($this->limit);
        }
        return view('livewire.table-brand', ['brands' => $brands]);
    }
}
