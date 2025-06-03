<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tag;


class AdminDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tags = \App\Models\Tag::withCount([
            'cars as sold_count' => function ($q) {
                $q->where('status', 'sold');
            },
            'cars as available_count' => function ($q) {
                $q->where('status', 'available');
            },
            'cars'
        ])->get()->sortByDesc('cars_count');

        return view('admin.dashboard', compact('tags'));
    }
}