<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SiteExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    //private $id;
    private $project_id;
    //private $date;

    //public function __construct($id, $date, $project_id)
    public function __construct($date, $project_id)
    {
        //$this->id = $id;
        $this->project_id = $project_id;
        $this->date = $date;
    }

    public function collection()
    {
        $dates = explode(' - ', $this->date);
        $start = $dates[0];
        $end = $dates[1];

        $getData = \Tritiyo\Site\Models\SiteInvoice::where('project_id', $this->project_id)->whereBetween('invoice_date', [$start, $end])->groupBy('site_id')->get();//->whereBetween('task_for', [$start, $end])->get();
        dd($getData);
        $v = [];
        foreach ($getData as $site) {
            $site_info = \Tritiyo\Site\Models\Site::where('id', $site->site_id)->first();
            $site_code = $site_info->site_code ?? NULL;
            $get_project = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first();
            $project = $get_project->name ?? NULL;
            $manager_name = \App\Models\User::where('id', $get_project->manager)->first()->name ?? NULL;
            $total_tasks = \Tritiyo\Task\Models\TaskSite::where('site_id', $site->site_id)->groupBy('task_id')->get()->count();
            $total_invoiced = \Tritiyo\Site\Models\SiteInvoice::where('site_id', $site->site_id)->get()->sum('invoice_amount');
            $completion_status = $site_info->completion_status ?? NULL;
            $invoice_type = \Tritiyo\Site\Models\SiteInvoice::where('site_id', $site->site_id)->orderBy('id', 'desc')->first()->invoice_type ?? NULL;
            //dd($invoice_type);

            $value = [];
            $v[] = [
                $value[] = $site_code,
                $value[] = $project,
                $value[] = $manager_name,
                $value[] = $total_tasks,
                $value[] = $total_invoiced,
                $value[] = $completion_status,
                $value[] = $invoice_type
            ];
        }

        dd($v);

        
        if (count($v) == count($getData)) {            
            return collect([$v]);
        }
    }

    public function headings(): array
    {
        return [
            'Site Code',
            'Project Name',
            'Project Manager',
            'Total Tasks',
            'Total Invoiced',
            'Completion Status',
            'Invoice Type'
        ];
    }

   
}
