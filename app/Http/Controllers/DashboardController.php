<?php

namespace App\Http\Controllers;

use App\Models\StudentApplications;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $agentId = auth()->id();

        $totalApplications = StudentApplications::where('agent_id', $agentId)->count();
        $pendingApplications = StudentApplications::where('agent_id', $agentId)
            ->where('status', 'Pending')
            ->count();
        $approvedApplications = StudentApplications::where('agent_id', $agentId)
            ->where('status', 'Approved')
            ->count();
        $inReviewApplications = StudentApplications::where('agent_id', $agentId)
            ->where('status', 'In Review')
            ->count();
        $totalStudents = Students::where('agent_id', $agentId)
            ->distinct('email')
            ->count();

        $data = [
            'total_applications' => $totalApplications,
            'pending_applications' => $pendingApplications,
            'approved_applications' => $approvedApplications,
            'in_review_applications' => $inReviewApplications,
            'total_students' => $totalStudents,
        ];
        return $this->respondSuccessWithData(message: 'Application stats retrieved successfully', data: $data);
    }

    public function applicationsTrend()
    {
        $agentId = auth()->id();
        $days = 7;
        $labels = [];
        $totalData = [];
        $approvedData = [];
        $pendingData = [];
        $inReviewData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');

            $total = StudentApplications::where('agent_id', $agentId)
                ->whereDate('created_at', $date)
                ->count();
            $totalData[] = $total;

            $approved = StudentApplications::where('agent_id', $agentId)
                ->where('status', 'Approved')
                ->whereDate('created_at', $date)
                ->count();
            $approvedData[] = $approved;

            $pending = StudentApplications::where('agent_id', $agentId)
                ->where('status', 'Pending')
                ->whereDate('created_at', $date)
                ->count();
            $pendingData[] = $pending;

            $inReview = StudentApplications::where('agent_id', $agentId)
                ->where('status', 'In Review')
                ->whereDate('created_at', $date)
                ->count();
            $inReviewData[] = $inReview;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Applications',
                    'data' => $totalData,
                ],
                [
                    'label' => 'Approved',
                    'data' => $approvedData,
                ],
                [
                    'label' => 'Pending',
                    'data' => $pendingData,
                ],
                [
                    'label' => 'In Review',
                    'data' => $inReviewData,
                ],
            ],
        ]);
    }

    public function applicationsStatus()
    {
        $agentId = auth()->id();

        $statusCounts = StudentApplications::where('agent_id', $agentId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $labels = $statusCounts->pluck('status')->toArray();
        $data = $statusCounts->pluck('count')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function monthlyApplications()
    {
        $agentId = auth()->id();
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $count = StudentApplications::where('agent_id', $agentId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function recentActivity()
    {
        $agentId = auth()->id();

        $activities = StudentApplications::where('agent_id', $agentId)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
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

        return response()->json($activities);
    }
}
