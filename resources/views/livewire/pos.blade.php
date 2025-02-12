<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <!-- Search Section -->
    <div class="mb-6">
        <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search product...">
    </div>

    <!-- Products Section -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Available Products</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">Product 1</p>
                    <p class="text-sm text-gray-600">$25.00</p>
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Add to Cart</button>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">Product 2</p>
                    <p class="text-sm text-gray-600">$40.00</p>
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Add to Cart</button>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">Product 3</p>
                    <p class="text-sm text-gray-600">$15.00</p>
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Cart</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-800">Product 1 x 2</span>
                <span class="text-gray-800 font-semibold">$50.00</span>
                <input type="number" class="w-16 p-2 border border-gray-300 rounded-lg" value="2" min="1">
            </div>
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-800">Product 2 x 1</span>
                <span class="text-gray-800 font-semibold">$40.00</span>
                <input type="number" class="w-16 p-2 border border-gray-300 rounded-lg" value="1" min="1">
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <h3 class="text-lg font-semibold text-gray-800">Total: $90.00</h3>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Payment Method</h3>
        <select class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="cash">Cash</option>
            <option value="credit_card">Credit Card</option>
            <option value="mobile_payment">Mobile Payment</option>
        </select>
    </div>

    <!-- Proceed Button Section -->
    <div class="text-center mb-6">
        <button class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition">
            Proceed
        </button>
    </div>

    <!-- Checkout Section -->
    <div class="text-center">
        <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Checkout
        </button>
    </div>
</div>
