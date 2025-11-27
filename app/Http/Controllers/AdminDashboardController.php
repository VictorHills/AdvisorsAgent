<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\StudentApplications;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $totalApplications = StudentApplications::count();

        $visa_application_granted = StudentApplications::where('status', 'visa_application_granted')
            ->count();

        $cas_ceo_loa_i20_stage = StudentApplications::where('status', 'cas_ceo_loa_i20_stage')
            ->count();

        $unconditional_offers_received = StudentApplications::where('status', 'unconditional_offers_received')
            ->count();

        $application_done_successfully = StudentApplications::where('status', 'application_done_successfully')
            ->count();

        $document_in_check = StudentApplications::where('status', 'document_in_check')
            ->count();

        $application_rejected = StudentApplications::where('status', 'application_rejected')
            ->count();

        $totalStudents = Students::distinct('email')
            ->count();

        $totalAgents = User::where('role_name', 'agent')->count();

        $data = [
            'total_students' => $totalStudents,
            'total_applications' => $totalApplications,
            'visa_application_granted' => $visa_application_granted,
            'cas_ceo_loa_i20_stage' => $cas_ceo_loa_i20_stage,
            'unconditional_offers_received' => $unconditional_offers_received,
            'application_done_successfully' => $application_done_successfully,
            'document_in_check' => $document_in_check,
            'application_rejected' => $application_rejected,
            'total_agents' => $totalAgents,
        ];
        return $this->respondSuccessWithData(message: 'Application stats retrieved successfully', data: $data);
    }

    public function applicationsTrend()
    {
        $days = 10;
        $labels = [];
        $totalData = [];
        $visa_application_granted_data = [];
        $cas_ceo_loa_i20_stage_data = [];
        $unconditional_offers_received_data = [];
        $application_done_successfully_data = [];
        $document_in_check_data = [];
        $application_rejected_data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');

            $total = StudentApplications::whereDate('created_at', $date)
                ->count();
            $totalData[] = $total;

            $visa_application_granted = StudentApplications::where('status', 'visa_application_granted')
                ->whereDate('created_at', $date)
                ->count();
            $visa_application_granted_data[] = $visa_application_granted;

            $cas_ceo_loa_i20_stage = StudentApplications::where('status', 'cas_ceo_loa_i20_stage')
                ->whereDate('created_at', $date)
                ->count();
            $cas_ceo_loa_i20_stage_data[] = $cas_ceo_loa_i20_stage;

            $unconditional_offers_received = StudentApplications::where('status', 'unconditional_offers_received')
                ->whereDate('created_at', $date)
                ->count();
            $unconditional_offers_received_data[] = $unconditional_offers_received;

            $application_done_successfully = StudentApplications::where('status', 'application_done_successfully')
                ->whereDate('created_at', $date)
                ->count();
            $application_done_successfully_data[] = $application_done_successfully;

            $application_rejected = StudentApplications::where('status', 'application_rejected')
                ->whereDate('created_at', $date)
                ->count();
            $application_rejected_data[] = $application_rejected;

            $document_in_check = StudentApplications::where('status', 'document_in_check')
                ->whereDate('created_at', $date)
                ->count();
            $document_in_check_data[] = $document_in_check;
        }

        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Applications',
                    'data' => $totalData,
                ],
                [
                    'label' => 'Document In Check',
                    'data' => $document_in_check_data,
                ],
                [
                    'label' => 'Application Done Successfully',
                    'data' => $application_done_successfully_data,
                ],
                [
                    'label' => 'Unconditional Offers Received',
                    'data' => $unconditional_offers_received_data,
                ],
                [
                    'label' => 'CAS/CEO/LOA/I20 Stage',
                    'data' => $cas_ceo_loa_i20_stage_data,
                ],
                [
                    'label' => 'Visa Application Granted',
                    'data' => $visa_application_granted_data,
                ],

                [
                    'label' => 'Application Rejected',
                    'data' => $application_rejected_data,
                ],
            ],
        ];
        return $this->respondSuccessWithData(message: 'Applications Trend retrieved successfully', data: $data);
    }

    public function applicationsStatus()
    {
        $statusCounts = StudentApplications::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $labels = $statusCounts->pluck('status')->toArray();
        $data = $statusCounts->pluck('count')->toArray();

        $data = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $this->respondSuccessWithData(message: 'Applications Status retrieved successfully', data: $data);
    }

    public function monthlyApplications()
    {
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $count = StudentApplications::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }

        $data = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $this->respondSuccessWithData(message: 'Monthly Applications retrieved successfully', data: $data);
    }

    public function recentActivity()
    {
        $activities = StudentApplications::orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($application) {
                $statusText = match ($application->status) {
                    'Approved' => 'Application approved',
                    'Pending' => 'New application submitted',
                    'In Review' => 'Application in review',
                    'Rejected' => 'Application rejected',
                    default => 'Status updated'
                };

                return [
                    'id' => $application->id,
                    'text' => $statusText . ' for ' . $application->first_name . ' ' . $application->last_name,
                    'time' => Carbon::parse($application->updated_at)->diffForHumans(),
                ];
            });

        return $this->respondSuccessWithData(message: 'Recent Activity retrieved successfully', data: $activities);
    }

    public function countryDistribution()
    {
        $agentId = auth()->id();

        $student_applications = StudentApplications::where('agent_id', $agentId)->pluck('country_of_preference')
            ->flatten()
            ->toArray();

        $countries = Countries::whereIn('id', $student_applications)->get()->map(function ($country) {
            return $country->name;
        });


        return $this->respondSuccessWithData(message: 'Country Distribution retrieved successfully', data: $countries);
    }

    public function monthlyAgentRegistration()
    {
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $count = User::where('role_name', 'agent')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }

        $data = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $this->respondSuccessWithData(message: 'Monthly Applications retrieved successfully', data: $data);
    }
}
