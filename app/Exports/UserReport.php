<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserReport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
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
        $user_id = $this->id;
        $getData = \Tritiyo\Task\Models\Task::leftjoin('tasks_site', 'tasks_site.task_id', 'tasks.id')
            ->select('tasks.*', 'tasks_site.site_id', 'tasks_site.resource_id')
            ->where(function ($q) use ($user_id) {
                $q->where('tasks.user_id', $user_id)
                    ->orWhere('tasks.site_head', $user_id)
                    ->orWhere('tasks_site.resource_id', $user_id);
            })
            ->whereBetween('tasks.task_for', [$start, $end])
            ->orderBy('tasks.id', 'desc')
            ->groupBy('tasks.id')
            ->get();
        $v = [];
        foreach ($getData as $task) {
            //Play Role
            $resources = \Tritiyo\Task\Models\TaskSite::where('task_id', $task->id)
                ->select('resource_id')
                ->groupBy('resource_id')
                ->get();
            $issetResource = $resources->contains('resource_id', $user_id);
            if ($user_id == $task->user_id) {
                $role = 'Project Manager';
            } elseif ($user_id == $task->site_head) {
                $role = 'Site Head';
            } elseif ($issetResource == true) {
                $role = 'As a Resource';
            }
            //site code
            $sites = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                ->select('sites.site_code')
                ->where('task_id', $task->id)
                ->groupBy('sites.site_code')
                ->get()->toArray();

            //Vehicle
            if ($user_id == $task->user_id) {
                $vehicle = \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task->id)
                    ->groupBy('vehicle_id')
                    ->get()->toArray();
                $vehicle_rent = implode(', ', array_column($vehicle, 'vehicle_rent'));
            } else {
                $vehicle_rent = '';
            }
            //Site Head
            if ($user_id == $task->site_head) {
                $sitehead = '';
            } else {
                $sitehead = \App\Models\User::where('id', $task->site_head)->first()->name ?? NULL;
            }

            //Project
            $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first();

            //Project Manager
            if ($user_id == $task->user_id) {
                $projectManager = '';
            } else {
                $projectManager = \App\Models\User::where('id', $task->user_id)->first()->name;
            }

            //requisition & Bill
            //if ($user_id == $task->site_head) {
                // $requisitionApprove = (new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id, false))->getTotal();
                //$billPrepared = (new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_prepared_by_resource', $task->id, false))->getTotal();
                //$billApprove = (new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_edited_by_accountant', $task->id, false))->getTotal();

                $requisitionApprove = \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('reba_amount', $task->id,'requisition_approved_by_accountant');
                $billPrepared = \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('bpbr_amount', $task->id,'bill_submitted_by_resource');
                $billApprove = \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('beba_amount', $task->id, 'bill_approved_by_accountant');

            // } else {
            //     $requisitionApprove = (new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id, false))->getTotal();
            //     $billPrepared = (new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_prepared_by_resource', $task->id, false))->getTotal();
            //     $billApprove = (new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_edited_by_accountant', $task->id, false))->getTotal();
            // }

            ##$task_for = Date::stringToExcel(date('m/d/Y', strtotime($getTask->task_for))) ?? NULL;

            $value = [];
            $v[] = [
                $value[] = $task->task_name,
                $value[] = Date::stringToExcel(date('d/m/Y', strtotime($task->task_for))) ?? NULL,
                $value[] = $task->task_type,
                $value[] = $role,
                $value[] = implode(', ', array_column($sites, 'site_code')),
                $value[] = $sitehead,
                $value[] = $project->name,
                $value[] = $projectManager,
                $value[] = $vehicle_rent,
                $value[] = $requisitionApprove,
                $value[] = $billPrepared,
                $value[] = $billApprove,


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
            'Play Role',
            'Site Code',
            'Site Head',
            'Project Name',
            'Project Manager',
            'Vehicle Rent',
            'Requsition Approved',
            'Bill Submit',
            'Bill Approved'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
