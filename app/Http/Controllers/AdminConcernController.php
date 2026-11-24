<?php

namespace App\Http\Controllers;

use App\Models\FacilityConcern;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminConcernController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q', ''));

        $query = FacilityConcern::with('user')->latest();

        if (in_array($status, array_keys(FacilityConcern::STATUSES), true)) {
            $query->where('status', $status);
        } else {
            $status = '';
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $like = '%'.$search.'%';
                $builder->where('reference_code', 'like', $like)
                    ->orWhere('title', 'like', $like)
                    ->orWhere('category', 'like', $like)
                    ->orWhere('building', 'like', $like)
                    ->orWhere('location', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('user', function ($userQuery) use ($like): void {
                        $userQuery->where('name', 'like', $like)
                            ->orWhere('email', 'like', $like);
                    });
            });
        }

        $concerns = $query->paginate(8)->withQueryString();
        $selectedConcern = $concerns->getCollection()->firstWhere('id', $request->integer('selected'))
            ?? $concerns->first();

        return view('admin.concerns.index', [
            'concerns' => $concerns,
            'selectedConcern' => $selectedConcern,
            'status' => $status,
            'search' => $search,
            'statuses' => FacilityConcern::STATUSES,
            'counts' => [
                'total' => FacilityConcern::count(),
                'pending' => FacilityConcern::where('status', 'pending')->count(),
                'in_progress' => FacilityConcern::where('status', 'in_progress')->count(),
                'resolved' => FacilityConcern::where('status', 'resolved')->count(),
            ],
        ]);
    }

    public function update(Request $request, FacilityConcern $concern): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(FacilityConcern::STATUSES))],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $concern->update([
            'status' => $data['status'],
            'admin_note' => trim((string) ($data['admin_note'] ?? '')) ?: null,
            'reviewed_by' => $request->user()->id,
        ]);

        $redirect = $request->input('return_to') === 'queue'
            ? redirect()->route('admin.concerns.index', ['selected' => $concern->id])
            : redirect()->route('concerns.show', $concern);

        return $redirect->with('success', 'The report status has been updated.');
    }
}
