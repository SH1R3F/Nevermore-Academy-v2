<?php

namespace App\Http\Controllers\Api;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AssignmentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentRequest;
use App\Http\Resources\AssignmentResource;

class AssignmentController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Assignment::class, 'assignment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::with('teacher')
            // If teacher only show his assignments.
            ->when(request()->user()->hasRole('teacher'), fn ($query) => $query->where('teacher_id', Auth::user()->id))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return AssignmentResource::collection($assignments)->additional([
            'can' => [
                'create_assignment' => request()->user()->can('create', Assignment::class)
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentRequest  $request
     * @param  \App\Http\Services\AssignmentService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request, AssignmentService $service)
    {
        $assignment = $service->store($request->validated());
        return $this->apiResponse(__('Assignment created successfully'), [
            'assignment' => new AssignmentResource($assignment)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        return new AssignmentResource($assignment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentRequest  $request
     * @param  \App\Models\Assignment  $assignment
     * @param  \App\Http\Services\AssignmentService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, Assignment $assignment, AssignmentService $service)
    {
        $service->update($request->validated(), $assignment);
        return $this->apiResponse(__('Assignment updated successfully'), [
            'assignment' => new AssignmentResource($assignment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment  $assignment)
    {
        $assignment->delete();
        return $this->apiResponse(__('Assignment deleted successfully'));
    }
}
