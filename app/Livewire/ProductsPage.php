<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\WithPagination;


#[Title('Products Page-Tech Soko Kenya')]

class ProductsPage extends Component
{
    use WithPagination;


    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);
        return view('livewire.products-page',[

            'products' => $productQuery->paginate(6),
            'brands' =>Brand::where('is_active',1)->get(['id','name','slug']),
            'categories' =>Category::where('is_active',1)->get(['id','name','slug']),

        ]);
    }
}
