<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Tag;

class SearchCars extends Component
{
    public $search = '';
    public $selectedTags = [];

    public function mount()
    {
        $this->selectedTags = request()->has('tags') ? request('tags', []) : [];
    }

    public function updatedSearch()
    {
        $this->render(); // Force re-render on search input change
    }

    public function searchOnEnter()
    {
        $this->render(); // Trigger render when Enter is pressed
    }

    public function render()
    {
        $cars = Car::query()
            ->where('status', 'available')
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($query) use ($search) {
                    $query->where('brand', 'like', $search)
                          ->orWhere('model', 'like', $search);
                });
            })
            ->when(!empty($this->selectedTags), function ($query) {
                $query->whereHas('tags', function ($query) {
                    $query->whereIn('tags.id', $this->selectedTags);
                });
            })
            ->get();

        $tags = Tag::all();

        return view('livewire.search-cars', [
            'cars' => $cars,
            'tags' => $tags,
        ]);
    }

    public function updatedSelectedTags()
    {
        $this->render();
    }
}