<div>
    <!-- Search Bar -->
    <input
        type="text"
        wire:model="search"
        placeholder="Search products..."
        class="w-full mb-4 px-3 py-2 border border-blue-300 rounded focus:ring focus:ring-blue-200">

    <!-- Product List -->
    <div>
        @if (count($products) > 0)
        @foreach ($products as $product)
            <div class="flex items-center justify-between mb-2 border-b pb-2">
                <div class="flex items-center">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 mr-4 rounded">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
                <button
                    wire:click="$emit('addToCart', {{ $product->id }})"
                    class="ml-4 bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded">
                    Add to Cart
                </button>
            </div>
        @endforeach
    @else
        <p class="text-gray-500">No products found.</p>
    @endif
    </div>
</div>

