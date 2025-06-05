<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class AdminDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tags = Tag::withCount([
            'cars as sold_count' => function ($q) {
                $q->where('status', 'sold');
            },
            'cars as available_count' => function ($q) {
                $q->where('status', 'available');
            },
            'cars'
        ])->get()->sortByDesc('cars_count');

        $total_cars = \App\Models\Car::count();
        $sold_cars = \App\Models\Car::where('status', 'sold')->count();
        $today_cars = \App\Models\Car::whereDate('created_at', now()->toDateString())->count();
        $total_users = \App\Models\User::has('cars')->count();
        $avg_cars_per_user = $total_users > 0 ? round($total_cars / $total_users, 2) : 0;
        $avg_views_per_car = $total_cars > 0 ? round(\App\Models\Car::avg('views'), 2) : 0;
        $total_views = \App\Models\Car::sum('views');

        return view('admin.dashboard', compact(
            'tags',
            'total_cars',
            'sold_cars',
            'today_cars',
            'total_users',
            'avg_cars_per_user',
            'avg_views_per_car',
            'total_views'
        ));
    }

    public function stats(): JsonResponse
    {
        $totalCars = Car::count();
        $maxCars = Car::max('id');
        $soldCars = Car::where('status', 'sold')->count();
        $todayCars = Car::whereDate('created_at', now()->toDateString())->count();
        $totalUsers = User::has('cars')->count();
        $maxUsers = User::count();
        $avgCarsPerUser = $totalUsers > 0 ? round(Car::count() / $totalUsers, 2) : 0;
        $avgViewsPerCar = $totalCars > 0 ? round(Car::avg('views'), 2) : 0;
        $totalViews = Car::sum('views');

        return response()->json([
            'total_cars' => $totalCars,
            'max_cars' => $maxCars,
            'sold_cars' => $soldCars,
            'today_cars' => $todayCars,
            'total_users' => $totalUsers,
            'max_users' => $maxUsers,
            'avg_cars_per_user' => $avgCarsPerUser,
            'avg_views_per_car' => $avgViewsPerCar,
            'total_views' => $totalViews, 
        ]);
    }
}