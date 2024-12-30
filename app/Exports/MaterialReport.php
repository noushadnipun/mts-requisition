<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MaterialReport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
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
        $getData = \Tritiyo\Task\Models\TaskMaterial::leftJoin('tasks', 'tasks.id', 'tasks_material.task_id')
            ->where('tasks_material.material_id', $this->id)
            ->whereBetween('tasks.task_for', [$start, $end])
            ->get();
        $v = [];
        foreach ($getData as $material) {
            $task = \Tritiyo\Task\Models\Task::where('id', $material->task_id)->first();
            $siteUsed = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                ->select('sites.site_code')
                ->where('tasks_site.task_id', $material->task_id)
                ->get()->toArray();
            $rseourceUse = \Tritiyo\Task\Models\TaskSite::leftJoin('users', 'users.id', 'tasks_site.resource_id')
                ->select('users.name')
                ->where('task_id', $material->task_id)
                ->groupBy('resource_id')
                ->get()
                ->toArray();


            $value = [];
            $v[] = [
                $value[] = $task->task_name,
                $value[] = Date::stringToExcel(date('m/d/Y', strtotime($task->task_for))) ?? NULL,
                $value[] = $task->task_type,
                $value[] = implode(', ', array_column($siteUsed, 'site_code')),
                $value[] = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name,
                $value[] = \App\Models\User::where('id', $task->user_id)->first()->name,
                $value[] = \App\Models\User::where('id', $task->site_head)->first()->name,
                $value[] = $material->material_amount,
                $value[] = $material->material_qty,
                $value[] = $material->material_note,
                $value[] = implode(',', array_column($rseourceUse, 'name')),
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
            'Site Code',
            'Project Name',
            'Project Manager',
            'Site Head',
            'Material Amount',
            'Material Qty',
            'Material Note',
            'Resource Used',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
