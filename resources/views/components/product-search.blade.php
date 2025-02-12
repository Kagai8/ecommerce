<div>
    <!-- Search Bar -->
    <input
        type="text"
        wire:model.debounce.300ms="search"
        placeholder="Search products..."
        class="w-full mb-4 px-3 py-2 border border-blue-300 rounded focus:ring focus:ring-blue-200">

    <!-- Product List -->
    <div>
        @forelse ($products as $product)
            <div class="flex items-center justify-between mb-2 border-b pb-2">
                <div class="flex items-center">
                    <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-12 h-12 mr-4 rounded">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $product['name'] }}</h3>
                        <p class="text-sm text-gray-500">${{ number_format($product['price'], 2) }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <!-- Quantity Controls -->
                    <button
                        wire:click="decreaseQuantity({{ $product['id'] }})"
                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                        -
                    </button>
                    <span class="mx-2 font-semibold">{{ $quantities[$product['id']] ?? 1 }}</span>
                    <button
                        wire:click="increaseQuantity({{ $product['id'] }})"
                        class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        +
                    </button>

                    <!-- Add to Cart Button -->
                    <button
                        wire:click="addToCart({{ $product['id'] }})"
                        class="ml-4 bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded">
                        Add to Cart
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No products found.</p>
        @endforelse
    </div>
</div>
