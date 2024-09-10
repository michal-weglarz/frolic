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
    <ul>
        @foreach ($categories as $category)
            <li class="p-4">
                <a class="text-lg">{{ $category->name }}</a>
                <p class="text-sm">{{ $category->description }}</p>

            </li>
            <hr/>
        @endforeach
    </ul>
</div>
