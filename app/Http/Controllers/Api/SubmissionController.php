<?php

namespace App\Http\Controllers\Api;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SubmissionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\SubmissionResource;

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
        $submissions = Submission::with('assignment', 'assignment.teacher')
            ->where('student_id', request()->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return SubmissionResource::collection($submissions);
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
        $this->authorize('create', [Submission::class, $assignment]);

        if ($service->userSubmittedBefore($assignment)) return $this->apiResponse(__('You already submitted once'));

        $submission = $service->store($request->validated(), $assignment);

        return $this->apiResponse(__('Submission saved successfully'), [
            'submission' => new SubmissionResource($submission)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment  $assignment)
    {
        $this->authorize('view', [Submission::class, $assignment]);

        $submission = $assignment->submissions()->where('student_id', request()->user()->id)->first();

        return new SubmissionResource($submission->load('student', 'assignment'));
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

        return $this->apiResponse(__('Submission degreed successfully'), [
            'submission' => new SubmissionResource($submission)
        ]);
    }
}
