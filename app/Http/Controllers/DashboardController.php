<?php

namespace App\Http\Controllers;

use App\Models\FacilityConcern;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isStaff()) {
            return redirect()->route('admin.concerns.index');
        }

        $base = FacilityConcern::where('user_id', $user->id);
        $counts = [
            'total' => (clone $base)->count(),
            'pending' => (clone $base)->where('status', 'pending')->count(),
            'in_progress' => (clone $base)->where('status', 'in_progress')->count(),
            'resolved' => (clone $base)->where('status', 'resolved')->count(),
        ];

        return view('dashboard', [
            'counts' => $counts,
            'concerns' => $base->latest()->take(6)->get(),
        ]);
    }
}
