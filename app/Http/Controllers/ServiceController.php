<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Interfaces\ServiceRepositoryInterface;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index(Request $request)
    {
        try {
            $services = $this->serviceRepository->allWithCategoryAndMonthlyReservations(
                $request->category
            );
            
            $categories = $this->serviceRepository->getCategories();
    
            return view('admin.services.index', compact('services', 'categories'));
    
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des services.');
        }
    }

    public function search(Request $request)
    {
        $output = "";
        $services = $this->serviceRepository->searchWithCategoryAndMonthlyReservations($request->search);

        foreach($services as $service)
        {
            $output .= '<tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-100 flex items-center justify-center text-purple-600">
                                        '.($service->image ? 
                                            '<img src="'.asset('storage/'.$service->image).'" class="h-full w-full object-cover rounded-md">' : 
                                            '<i class="fas fa-spa"></i>').'
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">'.$service->name.'</div>
                                        <div class="text-sm text-gray-500" title="'.$service->description.'">
                                            '.Str::limit($service->description, 50, '...').'
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">'.$service->category->name.'</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">'.$service->duration.' min</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">'.number_format($service->price, 2).'€</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                '.$service->reservations_count.' ce mois
                            </td>';

            if(auth()->user()->hasRole('admin')) {
                $output .= '<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="'.route('services.edit', $service->id).'" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="'.route('services.destroy', $service->id).'" method="POST" class="inline">
                                    '.csrf_field().'
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce service ?\')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>';
            }

            $output .= '</tr>';
        }

        return response($output);
    }

    public function create()
    {
        try {
            $categories = $this->serviceRepository->getCategories();
            return view('admin.services.create', compact('categories'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire de création.' . $e->getMessage());
        }
    }
    
    public function store(StoreServiceRequest $request)
    {
        try {
            $this->serviceRepository->create($request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du service.' . $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        try {
            $categories = $this->serviceRepository->getCategories();
            return view('admin.services.edit', compact('service', 'categories'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire d\'édition.' . $e->getMessage());
        }
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            $this->serviceRepository->update($service->id, $request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du service.' . $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        try {
            $this->serviceRepository->delete($service->id);
            return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du service.' . $e->getMessage());
        }
    }
}