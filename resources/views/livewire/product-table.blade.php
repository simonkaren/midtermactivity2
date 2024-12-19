
<div class="flex p-10 items-center flex-col">
    <h1 class="text-4xl font-semibold text-gray-800 mb-6">Products</h1>

    @if (session()->has('message'))
        <div class="alert alert-success bg-green-500 text-white mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Product Name Input -->
    <div class="mt-6 w-1/2">
        <input wire:model="productName" type="text" id="productName" class="bg-white border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Product Name" required />
    </div>
    @error('productName')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror      

    <!-- Quantity Input -->
    <div class="mt-6 w-1/2">
        <input wire:model="quantity" type="number" id="quantity" min="1" class="bg-white border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Quantity" required />
    </div>
    @error('quantity')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror  

    <!-- Price Input -->
    <div class="mt-6 w-1/2">
        <input wire:model="price" type="number" id="price" step="0.01" min="0" class="bg-white border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Price" required />
    </div>
    @error('price')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    <!-- Condition Dropdown -->
    <div class="mt-6 w-1/2">
        <label for="condition" class="block mb-1">Condition:</label>
        <select wire:model="condition" id="condition" class="bg-white border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <option>Select Condition</option>
            <option value="new">New</option>
            <option value="slightly_used">Slightly Used</option>
            <option value="old">Old</option>
        </select>
    </div>
    @error('condition')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    <!-- Description Textarea -->
    <div class="mt-6 w-1/2">
        <textarea wire:model="description" id="description" class="bg-white border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Description" rows="4" required></textarea>
    </div>
    @error('description')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    <!-- Submit Button -->
    <div class="mt-6">
        <button wire:loading.remove type="submit" wire:click="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Submit
        </button>
        <div wire:loading wire:target="submit">
            <!-- Loading spinner here -->
        </div>
    </div>

    <!-- Ordered Products Table -->
    <div class="mt-8 p-20 w-full">
        <h2 class="text-2xl font-bold mb-4">Products</h2>
        
        <div class="w-full">
            <table class="w-full bg-white border border-black">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Product Name</th>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Quantity</th>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Price</th>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Condition</th>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Description</th>
                        <th class="py-2 px-4 text-left text-gray-900 border-b border-black">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-t border-black">{{ $product->product_name }}</td>
                            <td class="py-2 px-4 border-t border-black">{{ $product->quantity }}</td>
                            <td class="py-2 px-4 border-t border-black">{{ $product->price }}</td>
                            <td class="py-2 px-4 border-t border-black">{{ $product->condition }}</td>
                            <td class="py-2 px-4 border-t border-black">{{ $product->description }}</td>
                            <td class="py-2 px-4 border-t border-black">
                                <div class="flex space-x-2">
                                    <button wire:click="openEditProductModal({{ $product->id }})" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                        Update
                                    </button>
                                    <button wire:click="openDeleteProductModal({{ $product->id }})" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-left">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Edit Product Modal -->
    @if($isEditProductModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Change Order</h3>
                    <div class="mt-2">
                        <input wire:model="editProductName" type="text" placeholder="Product Name" class="mb-3 px-4 py-2 border rounded-md w-full">
                        @error('editProductName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <input wire:model="editQuantity" type="number" min="1" placeholder="Quantity" class="mb-3 px-4 py-2 border rounded-md w-full">
                        @error('editQuantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <input wire:model="editPrice" type="number" step="0.01" placeholder="Price" class="mb-3 px-4 py-2 border rounded-md w-full">
                        @error('editPrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <select wire:model="editCondition" class="mb-3 px-4 py-2 border rounded-md w-full">
                            <option>Select Condition</option>
                            <option value="new">New</option>
                            <option value="slightly_used">Slightly Used</option>
                            <option value="old">Old</option>
                        </select>
                        @error('editCondition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <textarea wire:model="editDescription" placeholder="Description" rows="4" class="px-4 py-2 border rounded-md w-full"></textarea>
                        @error('editDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-center space-x-4 px-4 py-3">
                    <button wire:click="updateProduct" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md hover:bg-blue-700 focus:outline-none">
                        UPDATE
                    </button>
                    <button wire:click="closeEditProductModal" class="px-4 py-2 bg-gray-200 text-black text-base font-medium rounded-md hover:bg-gray-500 focus:outline-none">
                        CANCEL
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Product Modal -->
    @if($isDeleteProductModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Remove Order</h3>
                    <p class="mt-2 text-gray-500">Are you sure you want to remove this product? This action is irreversible.</p>
                </div>

                <div class="flex justify-center items-center space-x-4">
                    <button wire:click="deleteProduct" class="px-4 py-2 bg-red-500 text-white text-base rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        DELETE
                    </button>
                    <button wire:click="closeDeleteProductModal" class="px-4 py-2 bg-gray-500 text-white text-base rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        CANCEL
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
