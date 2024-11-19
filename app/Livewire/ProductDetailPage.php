<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;



#[Title('Product Page-Tech Soko Kenya')]

class ProductDetailPage extends Component
{
    public $slug;

    public function mount($slug){
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug', $this->slug)->firstorFail(),
        ]);
    }
}
