<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AssignmentRequest;

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
        $user = request()->user();
        $assignments = Assignment::with('teacher')
            // If teacher only show his assignments.
            ->when(Auth::user()->hasRole('teacher'), fn ($query) => $query->where('teacher_id', Auth::user()->id))
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return inertia('Assignments/Index', [
            'assignments' => $assignments->through(function ($assignment) use ($user) {
                $assignment->teacher = [
                    'id' => $assignment->teacher->id,
                    'name' => $assignment->teacher->name,
                ];
                $assignment->viewable = $user->can('view', $assignment);
                $assignment->editable = $user->can('update', $assignment);
                $assignment->deleteable = $user->can('delete', $assignment);
                $assignment->submitable = $user->can('create', [Submission::class, $assignment]);

                return $assignment;
            }),
            'can' => [
                'create_assignment' => $user->can('create', Assignment::class)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Assignments/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {
        Auth::user()->assignments()->create($request->validated());
        return redirect()->route('assignments.index')->with('status', 'Assignment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        $user = request()->user();
        $assignment = $assignment->load('submissions', 'submissions.student')->loadCount('submissions');
        $assignment->submissions->map(function ($submission) use ($user) {
            return [
                'id' => $submission->id,
                'degree' => $submission->degree,
                'student' => [
                    'id' => $submission->student->id,
                    'name' => $submission->student->name,
                ],
                'editable' => $user->can('update', $submission)
            ];
        });

        return inertia('Assignments/Show', [
            'assignment' => $assignment,
            'can' => [
                'update_assignment' => $user->can('update', $assignment)
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        return inertia('Assignments/Edit', [
            'assignment' => $assignment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssignmentRequest  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update($request->validated());
        return redirect()->back()->with('status', 'Assignment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->back()->with('status', 'Assignment deleted successfully');
    }
}
