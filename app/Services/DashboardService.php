<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\PatientRecord;
use Carbon\Carbon;
use Auth;

class DashboardService extends BaseService
{
    protected $patientRecord;

    public function __construct()
    {
        $this->patientRecord = new PatientRecord();
    }

    public function chart()
    {
        $labels = [];
        $values = [];

    	for ($month = 1; $month <= 12; $month++) {

            $date = Carbon::create()->month($month);

            $records = $this->patientRecord->query();

            $records= $records->whereMonth('examined_date', $month)
            ->whereYear('examined_date', now()->year)
            ->get();

            $total = 0;
            foreach ($records as $record) {
                $total += $record->total();
            }

            $labels[] = $date->translatedFormat('F');
            $values[] = $total;
        }

        return $this->response(true, 'Berhasil mendapatkan data', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function summary()
    {
        $query = $this->patientRecord->query();

        $totalPatientThisWeek = (clone $query)
            ->whereBetween('examined_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();

        $totalPatientThisMonth = (clone $query)
            ->whereYear('examined_date', now()->year)
            ->whereMonth('examined_date', now()->month)
            ->count();

        $totalPatientThisYear = (clone $query)
            ->whereYear('examined_date', now()->year)
            ->count();

        $data = [
            'total_patient_this_week' => $totalPatientThisWeek,
            'total_patient_this_month' => $totalPatientThisMonth,
            'total_patient_this_year' => $totalPatientThisYear,
        ];

        return $this->response(true, 'Berhasil mendapatkan data', $data);
    }
}