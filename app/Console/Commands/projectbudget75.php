<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tritiyo\Task\Models\Task;

class projectbudget75 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:budget75';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If 75% spent the budget of a project , mail to CFO and Project manager ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tls = Task::leftjoin('projects', 'projects.id', 'tasks.project_id')
                    ->select('tasks.id as task_id','tasks.task_name', 'tasks.project_id', 'tasks.user_id as user_id', 'projects.budget as project_budget', 'projects.manager as project_manager')
                    ->orderBy('projects.manager')
                    ->get();
        $i = 0;
        $html = 'Dear Concern, <br> This is to let you know that your requisition on respective project reaches 75% of total allocated budget.<br> Please stop raising task/requisition against this project<br>.';
        $html .= '<table border="1" width="100%" style="border-collapse:collapse">';
        $html .= '<tr align="center">';
        $html .= '<td><strong>Project Code</strong></td>';
        $html .= '<td><strong>Project Manager</strong></td>';
       // $html .= '<td><strong>Task Name</strong></td>';
        $html .= '<td><strong>Total Budget </strong></td>';
        $html .= '<td><strong>Spend</strong></td>';
        $html .= '<td><strong>% Spend</strong></td>';


        foreach($tls as $t){
            $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $t->task_id);
            $total_requisition = $rm->getTotal();
            $percentageOfBudget =  ($total_requisition * 100)/ $t->project_budget;

             if($percentageOfBudget == 75){
                 $html .= '</tr>';
                 $html .= '<tr align="center">';
                 $html .= '<td>' .\Tritiyo\Project\Models\Project::where('id', $t->project_id)->first()->code . '</td>';
                 $html .= '<td>' .\App\Models\User::where('id', $t->project_manager)->first()->name . '</td>';
               //$html .= '<td>' . $t->task_name. '</td>';
                 $html .= '<td>' . $t->project_budget. '</td>';
                 $html .= '<td>' .$total_requisition . '</td>';
                 $html .= '<td>' .$percentageOfBudget. '</td>';
                 $html .= '</tr>';
                $i++;
            }

       }


        if($i == 0){
			$emailAddress = 'nipun@tritiyo.com';
            return  \Tritiyo\Task\Helpers\MailHelper::send($html, 'Project Budget Spend 75%', $emailAddress);
        } else {
            $emailAddress = 'anowar@mtsbd.net';
            return  \Tritiyo\Task\Helpers\MailHelper::send($html, 'Project Budget Spend 75%', $emailAddress);
        }
    }
}
