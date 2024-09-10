<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


new class extends Component {
    public Collection $categories;

    public function mount(): void
    {
        $this->getCategories();
    }

    #[On('category-created')]
    public function getCategories(): void
    {
        $this->categories = Category::all();
    }
}; ?>

<div>
    <a href="{{ route('categories') }}"><h3 class="font-bold mb-1">Categories</h3></a>
    <ul>
        @foreach ($categories as $category)
            <li class="ml-1"><a href="/test" class="text-sm">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</div>
