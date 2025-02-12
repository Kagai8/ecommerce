<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $search = ''; // The search input value
    public $products = []; // Products matching the search query
    public $quantities = []; // Store product quantities

    public function updatedSearch()
    {
        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
        ->take(10)
        ->get();
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->quantities[$productId])) {
            $this->quantities[$productId]++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->quantities[$productId]) && $this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart($productId)
    {
        $quantity = $this->quantities[$productId] ?? 1;

        // Emit event with product and quantity
        $this->emit('addToCart', $productId, $quantity);
    }

    public function render()
    {
        return view('livewire.product-search', [
            'products' => $this->products,
        ]);
    }
}
