<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserJobRequest;
use App\Http\Resources\ReviewsResource;
use App\Http\Resources\UserJobResource;
use App\Http\Resources\UserResource;
use App\Mail\UserJobMail;
use App\Models\Attachment;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobsAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserJobResource::collection(UserJob::filter(request()->all())->paginate(8));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserJobResource
     */
    public function store(UserJobRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['status_id'] = 1;
        $validated['started'] = now();
        $user_job = UserJob::create($validated);
        if(isset($validated['attachments'])) {
            foreach ($validated['attachments'] as $attachment) {
                $file = $attachment->hashName();
                $attachment->store('public/user_jobs_attachments');
                UserJobsAttachment::create([
                    'name' => $file,
                    'user_job_id' => $user_job->id,
                ]);
            }
        }
        Mail::to($user_job->expert->email)->send(new UserJobMail($user_job));
        return new UserJobResource($user_job);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserJobResource
     */
    public function show(UserJob $userJob)
    {
        return new UserJobResource($userJob);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserJobResource
     */
    public function update(UserJobRequest $request, UserJob $userJob)
    {
        $userJob->update($request->validated());
        return new UserJobResource($userJob);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return UserJobResource
     */
    public function destroy(UserJob $userJob)
    {
        $userJob->delete();
        return new UserJobResource($userJob);
    }

    public function reviews(User $user) {
        $reviews = UserJob::where('expert_id', $user->id)
            ->whereNotNull('review')
            ->paginate(3);

        return ReviewsResource::collection($reviews);
    }

    public function attachment(Request $request, $attachment)
    {
        error_log($attachment);
        if (!$request->hasValidSignature()) {abort(401);}

        $path = Storage::disk('local')->path('public/user_jobs_attachments/') . UserJobsAttachment::find($attachment)->name;
        return response()->file($path);
    }
}
