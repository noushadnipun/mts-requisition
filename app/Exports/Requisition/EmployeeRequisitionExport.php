<?php

namespace App\Exports\Requisition;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use App\Models\EmployeeRequisition;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use \Tritiyo\Task\Models\Task;
use Tritiyo\Task\Models\TaskRequisitionBill;
use Tritiyo\Task\Models\TaskSite;

class EmployeeRequisitionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    private $date;
    private $project_id;

    /**
     * EmployeeRequisitionExport constructor.
     * @param $date
     */
    public function __construct($date, $project_id = null)
    {
        $this->date = $date;
        $this->project_id = $project_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
      //dd('ok');
        $dates = explode(' - ', $this->date);
        $start = $dates[0];
        $end = $dates[1];      	
          if(!empty($this->project_id)) {
            $getData = \Tritiyo\Task\Models\TaskRequisitionBill::leftjoin('tasks', 'tasks.id', 'tasks_requisition_bill.task_id')
              ->select('tasks_requisition_bill.*', 'tasks.task_for', 'tasks.project_id')
              ->where('tasks.project_id', $this->project_id)
              ->whereBetween('tasks.task_for', [$start, $end])
              ->get()->toArray();
          } else {
            $getData = \Tritiyo\Task\Models\TaskRequisitionBill::leftjoin('tasks', 'tasks.id', 'tasks_requisition_bill.task_id')
              ->select('tasks_requisition_bill.*', 'tasks.task_for', 'tasks.project_id')
              ->whereBetween('tasks.task_for', [$start, $end])
              ->get()->toArray();
          }
        $v = [];
        foreach ($getData as $data) {
            $total = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $data['task_id']);


            $getTask = Task::where('id', $data['task_id'])->first();
            $getTaskSite = TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                ->select('tasks_site.site_id', 'sites.site_code', 'sites.location')
                ->where('tasks_site.task_id', $data['task_id'])->groupBy('tasks_site.site_id')->get()->toArray();

            $getResource = TaskSite::leftjoin('users', 'users.id', 'tasks_site.resource_id')
                ->select('tasks_site.resource_id', 'users.name')
                ->where('tasks_site.task_id', $data['task_id'])->groupBy('tasks_site.resource_id')->get()->toArray();


            $task_for = Date::stringToExcel(date('d/m/Y', strtotime($getTask->task_for))) ?? NULL;

          	$task_name = $getTask->task_name;
          	$task_id = $getTask->id;
          	$requisition_by_manager = \App\Models\User::where('id', \Tritiyo\Project\Models\Project::where('id', $getTask->project_id)->first()->manager)->first()->name;
            $task_details = $getTask->task_details;
            $siteCode = implode(',', array_column($getTaskSite, 'site_code'));
            $location = implode(',', array_column($getTaskSite, 'location'));
            $resource = implode(',', array_column($getResource, 'name'));
            $project = \Tritiyo\Project\Models\Project::where('id', $getTask->project_id)->first()->code;
            $siteHead = \App\Models\User::where('id', $getTask->site_head)->first()->name ?? NULL;
            //$siteHeadMBankingInfo = \App\Models\User::where('id', $getTask->site_head)->first()->mbanking_information;
          
          if(!empty($data['requisition_approve_amount_accountant'])) {
                $mobileBankingInfo = explode(' | ', $data['requisition_approve_amount_accountant']);
                //dump($mobileBankingInfo = explode(' | ', $data['requisition_approve_amount_accountant']));
                $mobileBankingInfoType = $mobileBankingInfo[0] ?? NULL;
                $mobileBankingInfoNo = $mobileBankingInfo[1] ?? NULL;
          } else {
                $mobileBankingInfoType = NULL;
                $mobileBankingInfoNo = NULL;
          }
          $value = [];
          	if(!empty($siteHead)){
                $v[] = [
                        $value[] = $task_for,
                        $value[] = $requisition_by_manager,
                        $value[] = $task_name,
                        $value[] = $task_id,
                        $value[] = $task_details,
                        $value[] = $project,
                        $value[] = $siteCode,
                        $value[] = $location,
                        $value[] = $siteHead,
                        $value[] = $mobileBankingInfoType,
                        $value[] = $mobileBankingInfoNo,
                        $value[] = $resource,

                        $value[] = $total->getVehicleTotal(),
                        $value[] = $total->getMaterialTotal(),
                        $value[] = $total->getRegularTotal(),
                        $value[] = $total->getTransportTotal(),
                        $value[] = $total->getPurchaseTotal(),
                        $value[] = $total->getTotal(),
                ];
            }
            //  else {
            // 	//$v []= [];
            // }
        }

        // dump(count($getData));
        // dd(count($v));

        // if (count($v) == count($getData)) {          
            return collect([$v]);
        // }
    }

    public function headings(): array
    {
        return [
          	'Task For (Date)',
          	'Requisition By (Manager)',
          	'Task Name',
          	'Task ID',
            'Description',
            'Project Code',
            'Site Code',
            'Site Location',
            'Site Head',
          	'Through',
            'Mobile Banking No.',
            'Resources',
            'Vehicle Rent',
            'Material Cost',
            'Regular Amount (DA, Labour, Other)',
            'Transport Total',
            'Purchase Total',
            'Total Amount'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
