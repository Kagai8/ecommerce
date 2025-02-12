@push('styles')
    @livewireStyles
    @vite('resources/css/app.css')
@endpush

@push('scripts')
    @livewireScripts
    @vite('resources/js/app.js')
@endpush

<x-filament-panels::page>
    <div class="wrapper">
        <div class="container mx-auto p-4 bg-gray-100 min-h-screen">
            <h1 class="text-2xl font-bold mb-4 text-blue-600">POS System</h1>

            <div class="grid grid-cols-2 gap-4">
                <!-- Left Section: Product Selection -->
                <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200">
                    <h2 class="text-lg font-semibold mb-4 text-blue-600">Select Products</h2>

                    <!-- Embed Livewire Component -->
                    @livewire('product-search')

                </div>

                <!-- Right Section: Cart and Summary -->
                <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 flex flex-col">
                    <h2 class="text-lg font-semibold mb-4 text-blue-600">Cart</h2>

                    <!-- Cart Items -->
                    <div class="overflow-y-auto max-h-60 flex-grow bg-gray-50 p-2 rounded">
                        @foreach ([
                            ['name' => 'Product A', 'quantity' => 2, 'price' => 10.00],
                            ['name' => 'Product B', 'quantity' => 1, 'price' => 15.00],
                            ['name' => 'Product C', 'quantity' => 3, 'price' => 20.00],
                            ['name' => 'Product D', 'quantity' => 1, 'price' => 25.00],
                            ['name' => 'Product E', 'quantity' => 2, 'price' => 30.00]
                        ] as $item)
                            <div class="flex items-center justify-between mb-2 border-b pb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                </div>
                                <div class="flex items-center">
                                    <button
                                        wire:click="removeFromCart('{{ $item['name'] }}')"
                                        class="text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-4 border-t pt-4 sticky bottom-0 bg-gray-100 p-4 rounded">
                        <div class="flex justify-between mb-2 text-gray-800">
                            <span>Subtotal:</span>
                            <span>$160.00</span>
                        </div>
                        <div class="flex justify-between mb-2 text-gray-800">
                            <span>Tax (10%):</span>
                            <span>$16.00</span>
                        </div>
                        <div class="flex justify-between mb-4 text-blue-600 font-semibold">
                            <span>Total:</span>
                            <span>$176.00</span>
                        </div>

                        <!-- Payment Options -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Payment Method</h3>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="payment" value="cash" class="mr-2">
                                    <span>Cash</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment" value="mpesa" class="mr-2">
                                    <span>Mpesa</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment" value="credit" class="mr-2">
                                    <span>Credit</span>
                                </label>
                            </div>
                        </div>

                        <button
                            wire:click="checkout"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
