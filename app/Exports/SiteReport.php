<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SiteReport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    private $id;
    private $date;

    public function __construct($id, $date)
    {
        $this->id = $id;
        $this->date = $date;
    }

    public function collection()
    {
        $dates = explode(' - ', $this->date);
        $start = $dates[0];
        $end = $dates[1];
        $getData = \Tritiyo\Task\Models\TaskSite::leftjoin('tasks', 'tasks.id', 'tasks_site.task_id')
            ->select('tasks_site.*', 'tasks.task_for')
            ->where('tasks_site.site_id', $this->id)
            ->whereBetween('tasks.task_for', [$start, $end])
            ->groupBy('tasks_site.task_id')
            ->get();
        $v = [];
        foreach ($getData as $data) {
            $site = \Tritiyo\Site\Models\Site::where('id', $this->id)->first();
            $task_name = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_name;
            $task_fors = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_for;
            $task_for = Date::stringToExcel(date('d/m/Y', strtotime($task_fors))) ?? NULL;
            $task_type = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_type;
            $vehicleUsed = \Tritiyo\Task\Models\TaskVehicle::leftjoin('vehicles', 'vehicles.id', 'tasks_vehicle.vehicle_id')
                ->select('vehicles.name')
                ->where('tasks_vehicle.task_id', $data->task_id)
                ->get()->toArray();
            $materialUsed = \Tritiyo\Task\Models\TaskMaterial::leftjoin('materials', 'materials.id', 'tasks_material.material_id')
                ->select('materials.name')
                ->where('tasks_material.task_id', $data->task_id)
                ->get()->toArray();
            //Purchase Elements
            $taskId = $data->task_id;
            $obr = new \Tritiyo\Task\Helpers\RequisitionData('requisition_edited_by_accountant', $taskId);
            $purchases = $obr->getPurchaseData();
            //Budget Elements
            $total_project_budget = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()->budget;
            $total_sites = \Tritiyo\Site\Models\Site::where('project_id', '=', $site->project_id)->get()->count();

            $value = [];
            $v[] = [
                $value[] = $task_name,
                $value[] = $task_for,
                $value[] = $task_type,
                $value[] = implode(', ', array_column($vehicleUsed, 'name')),
                $value[] = implode(', ', array_column($materialUsed, 'name')),
                $value[] = implode(', ', array_column($purchases, 'pa_note')),
                //$value[] = implode(',',array_column($purchases, 'pa_amount')),
                $value[] = $total_project_budget / $total_sites,
                $value[] = (new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $taskId))->getTotal(),
                $value[] = $site->completion_status,
            ];
        }
        if (count($v) == count($getData)) {
            return collect([$v]);
        }
    }

    public function headings(): array
    {
        return [
            'Task Name',
            'Task For',
            'Task Type',
            'Vehicle Used',
            'Material Used',
            'Purchase Note',
            //'Purchase Amount',
            'Budget',
            'Expense',
            'Completion Status',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
