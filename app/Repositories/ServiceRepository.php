<?php
namespace App\Repositories;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Interfaces\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function allWithCategoryAndMonthlyReservations($categoryId = null, $perPage = 5)
    {
        $query = Service::with(['category', 'reservations' => function($query) {
            $query->whereMonth('datetime', now()->month)
                  ->whereYear('datetime', now()->year);
        }])->withCount(['reservations' => function($query) {
            $query->whereMonth('datetime', now()->month)
                  ->whereYear('datetime', now()->year);
        }]);
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query->paginate($perPage);
    }

    public function searchWithCategoryAndMonthlyReservations($searchTerm)
    {
        return Service::with(['category'])
            ->withCount(['reservations' => function($query) {
                $query->whereMonth('datetime', now()->month)
                      ->whereYear('datetime', now()->year);
            }])
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            })
            ->get();
    }

    public function create(array $data)
    {
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('services', 'public');
        }

        return Service::create($data);
    }

    public function update($id, array $data)
    {
        $service = Service::findOrFail($id);

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $data['image']->store('services', 'public');
        }

        $service->update($data);
        return $service;
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        return $service->delete();
    }

    public function find($id)
    {
        return Service::with('category')->findOrFail($id);
    }

    public function getCategories()
    {
        return Category::all();
    }
}