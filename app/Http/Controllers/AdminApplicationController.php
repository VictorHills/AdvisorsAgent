<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Mail\UpdateApplicationStatusEmail;
use App\Models\ApplicationStatus;
use App\Models\StudentApplications;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $query = StudentApplications::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $applications = $query->latest()->paginate($perPage);

        return ApplicationResource::collection($applications);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $application = StudentApplications::findOrFail($id);
        return $this->respondSuccessWithData(message: 'Application created successfully', data: new ApplicationResource($application));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = StudentApplications::findOrFail($id);
        $oldStatus = $application->status;
        $application->update($request->all() + ['bdm_officer_id' => auth()->id()]);

        $agent = User::where('id', $application->agent_id)->first();
        $student = User::where('id', $application->student_id)->first();
        $newStatus = ApplicationStatus::where('status_code', $request->status_name)->first();
        $oldStatusName = ApplicationStatus::where('status_code', $oldStatus)->first();

        try {
            Mail::to($agent->email)->bcc([config('app.admin_email'), config('app.counselor_email')])
                ->send(new UpdateApplicationStatusEmail(
                    application: $application,
                    oldStatus: $oldStatusName->status_name ?? 'Pending',
                    newStatus: $newStatus->status_name ?? 'Pending',
                ));
        } catch (Exception $exception) {
            Log::debug('Email could not be sent: ' . $exception->getMessage());
        }


        if ($request->status_name === 'conditional_offers_received' || $request->status_name === 'unconditional_offers_received') {
            try {

                Mail::to($student->email)->bcc([config('app.admin_email'), config('app.counselor_email'), auth()->user()->email])
                    ->send(new UpdateApplicationStatusEmail(
                        application: $application,
                        oldStatus: $oldStatusName->status_name,
                        newStatus: $newStatus->status_name,
                    ));
            } catch (Exception $exception) {
                Log::debug('Email could not be sent: ' . $exception->getMessage());
            }
        }

        return $this->respondSuccessWithData(message: 'Application updated successfully', data: new ApplicationResource($application));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
