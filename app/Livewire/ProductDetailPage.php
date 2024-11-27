<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;



#[Title('Product Page-Tech Soko Kenya')]

class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;

    public $quantity = 1;

    public function mount($slug){
        $this->slug = $slug;
    }

    public function increaseQty(){
        $this->quantity++;
    }

    public function decreaseQty(){
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // add product to cart method
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCartWithQuantity($product_id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully',[
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,

        ]);
    }

    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug', $this->slug)->firstorFail(),
        ]);
    }
}
