<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * List all branches ordered by the nearest to the user
     */
    public function index(Request $request)
    {
        $branches = Branch::query()
            ->orderByRaw("(ST_DISTANCE(ST_GeomFromText('{$request->user()->location->point}'), location))")
            ->get();

        return inertia('Branches/Index', [
            'branches' => $branches,
            'location' => $request->user()->location->point
        ]);
    }
}
