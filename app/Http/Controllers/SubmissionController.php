<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Services\SubmissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SubmissionRequest;
use SebastianBergmann\Type\VoidType;

class SubmissionController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Submission::class, 'submission', [
            'except' => ['create', 'store', 'show']
        ]); // In create() we have to pass a third parameter.
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = request()->user();

        $submissions = Submission::with('assignment', 'assignment.teacher')
            ->where('student_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return inertia('Submissions/Index', [
            'submissions' => $submissions->through(function ($submission) use ($user) {
                $submission->viewable = $user->can('view', [Submission::class, $submission->assignment]);
                $submission->assignment = [
                    'id' => $submission->assignment->id,
                    'title' => $submission->assignment->title,
                    'deadline' => $submission->assignment->deadline,
                    'teacher' => [
                        'id' => $submission->assignment->teacher->id,
                        'name' => $submission->assignment->teacher->name,
                    ],
                ];
                return $submission;
            }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function create(Assignment $assignment)
    {
        // Can we do this in constructor? or in routes?
        $this->authorize('create', ['App\Models\Submission', $assignment]);

        // Student can only submit assignment once.
        if ($this->userSubmittedBefore($assignment)) return redirect()->route('submissions.show', $assignment->id)->with('status', 'You already submitted once');

        return inertia('Submissions/Create', compact('assignment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubmissionRequest  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function store(SubmissionRequest $request, Assignment $assignment, SubmissionService $service)
    {
        // Can we do this in constructor? or in routes?
        $this->authorize('create', ['App\Models\Submission', $assignment]);

        // Student can only submit assignment once.
        if ($this->userSubmittedBefore($assignment)) return redirect()->route('submissions.show', $assignment->id)->with('status', 'You already submitted once');

        $service->store($request->validated(), $assignment);

        return redirect()->route('assignments.index')->with('status', 'Submission saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        // Can we do this in constructor? or in routes?
        $this->authorize('view', ['App\Models\Submission', $assignment]);

        $submission = $assignment->submissions()->where('student_id', Auth::user()->id)->first();

        return inertia('Submissions/Show', compact('assignment', 'submission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Submission $submission)
    {
        return inertia('Submissions/GiveDegree', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission, SubmissionService $service)
    {
        // I only validate one field should I put it in a form request?
        $data = $request->validate(['degree' => ['required', 'numeric']]);

        $service->degreeSubmission($data, $submission);

        return redirect()->route('assignments.show', $submission->assignment_id)->with('status', 'Submission degreed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        //
    }

    private function userSubmittedBefore(Assignment $assignment): bool
    {
        // Is here a good place for this? Or should I put it inside policy?
        // This is dealing with the request I guess we shouldn't put inside a service
        // What about the return? it redirects the user so shouldn't the redirection be handled in the controller method itself?
        return !!$assignment->submissions()->where('student_id', Auth::user()->id)->count();
    }
}
