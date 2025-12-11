<?php
namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormCreateProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $brandId;
    public $image;
    public $oldImage;
    public $code;
    public $sensor_type;
    public $sensor_size;
    public $resolution;
    public $weight;
    public $battery;
    public $description;

    protected $rules = [
        'name'        => 'required|string|max:255',
        'brandId'     => 'required|exists:brands,id',
        'image'       => 'nullable|image|max:2048',
        'code'        => 'required|string|unique:products,code',
        'sensor_type' => 'nullable|string',
        'sensor_size' => 'nullable|string',
        'resolution'  => 'nullable|string',
        'weight'      => 'nullable|string',
        'battery'     => 'nullable|string',
        'description' => 'nullable|string',
    ];

    public function resetForm()
    {
        $this->reset([
            'name', 'brandId', 'image', 'oldImage', 'code',
            'sensor_type', 'sensor_size', 'resolution',
            'weight', 'battery', 'description',
        ]);
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'name'        => $this->name,
                'brand_id'    => $this->brandId,
                'code'        => $this->code,
                'sensor_type' => $this->sensor_type,
                'sensor_size' => $this->sensor_size,
                'resolution'  => $this->resolution,
                'weight'      => $this->weight,
                'battery'     => $this->battery,
                'description' => $this->description,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('products', 'public');
            }

            Product::create($data);
            $this->resetForm();
            session()->flash('success', 'Product added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.form-create-product', [
            'brands' => Brand::all(),
        ]);
    }
}
