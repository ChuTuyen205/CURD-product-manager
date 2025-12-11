<?php
namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TableProduct extends Component
{
    use WithPagination, WithFileUploads;

    public $limit  = 10;
    public $search = '';

    // Dữ liệu form cập nhật
    public $productId;
    public $name;
    public $brandId;
    public $image;
    public $code;
    public $sensor_type;
    public $sensor_size;
    public $resolution;
    public $weight;
    public $battery;
    public $description;

    // Rules validation (tuỳ chọn, thêm nếu cần)
    protected $rules = [
        'name'        => 'required|string|max:255',
        'brandId'     => 'required|exists:brands,id',
        'image'       => 'nullable|image|max:2048', // Hỗ trợ file ảnh, tối đa 2MB
        'code'        => 'required|string|unique:products,code,' . '$productId',
        'sensor_type' => 'nullable|string',
        'sensor_size' => 'nullable|string',
        'resolution'  => 'nullable|string',
        'weight'      => 'nullable|numeric',
        'battery'     => 'nullable|string',
        'description' => 'nullable|string',
    ];

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            if ($product->image) {
                Storage::disk('public')->delete($product->image); // Xóa ảnh cũ
            }
            $product->delete();
            flash()->success('Xoá thành công!');
        } catch (\Exception $e) {
            flash()->error('Xoá thất bại! ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct()
    {
        $this->validate();

        try {
            $product = Product::findOrFail($this->productId);

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

            // Xử lý upload ảnh
            if ($this->image) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image); // Xóa ảnh cũ
                }
                $data['image'] = $this->image->store('products', 'public');
            }

            $product->update($data);
            flash()->success('Cập nhật thành công!');
            $this->reset(['productId', 'name', 'brandId', 'image', 'code', 'sensor_type', 'sensor_size', 'resolution', 'weight', 'battery', 'description']);
        } catch (\Exception $e) {
            flash()->error('Cập nhật thất bại! ' . $e->getMessage());
        }
    }

    /**
     * Render view
     */
    public function render()
    {
        // Lấy danh sách sản phẩm với phân trang và tìm kiếm
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('code', 'like', "%{$this->search}%")
                    ->orwhere('sensor_type', 'like', "%{$this->search}%")
                    ->orWhere('sensor_size', 'like', "%{$this->search}%")
                    ->orWhere('resolution', 'like', "%{$this->search}%")
                    ->orWhere('weight', 'like', "%{$this->search}%")
                    ->orWhere('battery', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('brand_id', 'like', "%{$this->search}%");
            })
            ->paginate($this->limit);

        $brands = Brand::all();

        return view('livewire.table-product', ['products' => $products, 'brands' => $brands]);
    }
}
