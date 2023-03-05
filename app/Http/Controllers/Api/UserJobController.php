<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserJobRequest;
use App\Http\Resources\ReviewsResource;
use App\Http\Resources\UserJobResource;
use App\Http\Resources\UserResource;
use App\Mail\BillMail;
use App\Mail\StatusMail;
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
        return UserJobResource::collection(UserJob::filter(request()->all())->orderBy('id', 'desc')->paginate(8));
    }

    public function offers()
    {
        return UserJobResource::collection(UserJob::where('expert_id', auth()->user()->id)->paginate(8));
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
        $validated = $request->validated();
        $userJob->update($validated);
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

    public function setBill(Request $request, UserJob $user_job) {
        $validated = $request->validate([
            'price' => 'numeric|between:0,1000',
        ]);
        $validated['status_id'] = 5;
        $user_job->update($validated);
        Mail::to($user_job->expert->email)->send(new BillMail($user_job));
        return response()->json([
            'data' => 'Rēķins tika nosūtīts!'
        ]);
    }

    public function sessionCreate(Request $request, UserJob $user_job) {
        if (!isset($user_job->price)) {
            return response()->json([
                'data' => 'Darbam nav vēl izrakstīts čeks',
            ], 400);
        }
        $bill = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount_decimal' => round($user_job->price * 100),
                    'product_data' => [
                        'name' => 'Maksa par darbu',
                        'description' => "Darba id: $user_job->id",
                    ]
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => config('app.app') . "/bill/success?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' =>  config('app.app') . '/bill/cancel',
        ]);

        $user_job->update(['payment_session_id' => $bill->id]);

        return response()->json([
            'data' => [
                'url' => $bill->url,
            ],
        ]);

    }

    public function handleCheckout(Request $request) {
        $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        $job = UserJob::where('payment_session_id', $request->get('session_id'))->firstOrFail();
        if($checkoutSession->payment_status === 'paid' && $checkoutSession->status === 'complete') {
            $job->update([
                'status_id' => 4,
            ]);
            Mail::to([$job->user->email, $job->expert->email])->send(new StatusMail($job));
            return response()->json([
                'data' => $checkoutSession,
            ]);
        }

        return response()->json([
            'data' => 'Kaut kas nogāja greizi',
        ], 400);
    }

    public function startJob(UserJob $user_job) {
        $user_job->started = \Carbon\Carbon::now();
        $user_job->status_id = 3;
        $user_job->save();
        Mail::to($user_job->user->email)->send(new StatusMail($user_job));
        return new UserJobResource($user_job);
    }

    public function endJob(UserJob $user_job) {
        if (!isset($user_job->started)) {
            return response()->json([
                'data' => 'Darbs sākumā ir jāuzsāk',
            ], 400);
        }
        $user_job->end = \Carbon\Carbon::now();
        $user_job->status_id = 5;
        $user_job->save();
        Mail::to($user_job->user->email)->send(new StatusMail($user_job));
        return new UserJobResource($user_job);
    }

    public function acceptJob(UserJob $user_job) {
        $user_job->status_id = 2;
        $user_job->save();
        Mail::to($user_job->user->email)->send(new StatusMail($user_job));
        return new UserJobResource($user_job);
    }

    public function declineJob(UserJob $user_job) {
        $user_job->status_id = 6;
        $user_job->save();
        Mail::to($user_job->user->email)->send(new BillMail($user_job));
        return new UserJobResource($user_job);
    }
}
