<?php

namespace App\Livewire;

use App\Models\Product; // Change to import the Product model
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    // Public properties for the form and modal
    public $productName, $quantity, $price, $condition, $description;
    public $editProductName, $editQuantity, $editPrice, $editCondition, $editDescription;
    public $isEditProductModalOpen = false, $isDeleteProductModalOpen = false, $productIdBeingDeleted;

    // Open edit modal and load product data
    public function openEditProductModal($productId)
    {
        $product = Product::find($productId);

        $this->productIdBeingDeleted = $productId; // Store product ID for deletion
        $this->editProductName = $product->product_name;
        $this->editQuantity = $product->quantity;
        $this->editPrice = $product->price;
        $this->editCondition = $product->condition;
        $this->editDescription = $product->description;

        $this->isEditProductModalOpen = true;
    }

    // Close the edit modal
    public function closeEditProductModal()
    {
        $this->isEditProductModalOpen = false;
        $this->resetEditForm();
    }

    // Handle product update
    public function updateProduct()
    {
        $this->validate([
            'editProductName' => 'required|string|max:100',
            'editQuantity' => 'required|integer|min:1',
            'editPrice' => 'required|numeric|min:0',
            'editCondition' => 'required|string|in:new,slightly_used,old',
            'editDescription' => 'nullable|string|max:255',
        ]);

        $product = Product::find($this->productIdBeingDeleted);

        $product->update([
            'product_name' => $this->editProductName,
            'quantity' => $this->editQuantity,
            'price' => $this->editPrice,
            'condition' => $this->editCondition,
            'description' => $this->editDescription,
        ]);

        session()->flash('message', 'Product successfully updated!');

        $this->closeEditProductModal();
    }

    // Open delete modal and store the product ID
    public function openDeleteProductModal($productId)
    {
        $this->productIdBeingDeleted = $productId;
        $this->isDeleteProductModalOpen = true;
    }

    // Close the delete modal
    public function closeDeleteProductModal()
    {
        $this->isDeleteProductModalOpen = false;
    }

    // Handle product deletion
    public function deleteProduct()
    {
        $product = Product::find($this->productIdBeingDeleted);
        $product->delete();

        session()->flash('message', 'Product successfully deleted!');

        $this->closeDeleteProductModal();
    }

    // Reset the edit form data
    private function resetEditForm()
    {
        $this->editProductName = '';
        $this->editQuantity = '';
        $this->editPrice = '';
        $this->editCondition = '';
        $this->editDescription = '';
    }

    public function submit()
    {
        sleep(2);

        // Validate the input data
        $this->validate([
            'productName' => 'required|string|max:100', // Changed to productName
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|in:new,slightly_used,old', // Updated validation
            'description' => 'nullable|string|max:255', // Description is optional
        ]);

        // Create a new product
        Product::create([
            'product_name' => $this->productName,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'condition' => $this->condition,
            'description' => $this->description,
        ]);

        // Reset the form fields after creating the product
        $this->reset(['productName', 'quantity', 'price', 'condition', 'description']);

        // Flash a success message
        session()->flash('message', 'Product successfully created!');
    }

    public function render()
    {
        return view('livewire.product-table', [
            'products' => Product::paginate(3), // Change to fetch products
        ]);
    }
}