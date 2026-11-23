<?php

namespace App\Http\Controllers;

use App\Models\FacilityConcern;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConcernController extends Controller
{
    public function create(): View
    {
        return view('concerns.create', [
            'categories' => FacilityConcern::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'in:'.implode(',', FacilityConcern::CATEGORIES)],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:15', 'max:5000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $photoPath = $request->file('photo')?->store('concerns', 'local');

        $concern = FacilityConcern::create([
            'user_id' => $request->user()->id,
            'category' => $data['category'],
            'location' => trim($data['location']),
            'description' => trim($data['description']),
            'photo_path' => $photoPath,
        ]);

        $concern->update([
            'reference_code' => 'CF-'.now()->format('Y').'-'.str_pad((string) $concern->id, 6, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('concerns.show', $concern)
            ->with('success', 'Your facility concern has been submitted. Keep the reference number for follow-up.');
    }

    public function show(Request $request, FacilityConcern $concern): View
    {
        abort_unless($request->user()->isAdmin() || $concern->user_id === $request->user()->id, 403);

        return view('concerns.show', [
            'concern' => $concern->load(['user', 'reviewer']),
            'statuses' => FacilityConcern::STATUSES,
        ]);
    }

    public function photo(Request $request, FacilityConcern $concern): BinaryFileResponse
    {
        abort_unless($request->user()->isAdmin() || $concern->user_id === $request->user()->id, 403);
        abort_unless($concern->photo_path, 404);

        $path = Storage::disk('local')->path($concern->photo_path);
        abort_unless(is_file($path), 404);

        return response()->file($path);
    }
}
