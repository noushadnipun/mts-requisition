<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tritiyo\Site\Models\Site;

class projectsitecomplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:sitecomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $start = date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'));
        $end = date('Y-m-d');
        $projects = \Tritiyo\Task\Models\Task::leftjoin('projects', 'projects.id', 'tasks.project_id')
                    ->select('tasks.id as task_id' ,'tasks.task_name', 'tasks.task_for', 'tasks.project_id', 'projects.code', 'projects.manager')
                    ->whereBetween('tasks.created_at', [$start, $end])
                    ->groupBy('tasks.project_id')
                    ->get();
        $i = 0;
        $html = "Dear Concern, <br>Please find the below table for your site completion day count. Please complete the site within sort time.";
        $html .= '<table border="1" width="100%" style="border-collapse:collapse">';
        $html .= '<tr align="center">';
        $html .= '<td><strong>Project Code</strong></td>';
        $html .= '<td><strong>Project Manager</strong></td>';
        $html .= '<td><strong>Site Code</strong></td>';
        $html .= '<td><strong>Site Running Date Count</strong></td>';
        //$html .= '<td><strong>Task Name</strong></td>';
        $html .= '<td><strong>Percentage of Site Complete</strong></td>';

        foreach($projects as $project){
            $taskSite = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                                    ->select('sites.site_code')
                                    ->where('tasks_site.task_id',$project->task_id)->groupBy('site_id')->get()->toArray();
            $siteCode = implode(', ', array_column($taskSite, 'site_code'));

            $totalSite = count(Site::where('project_id', $project->project_id)->get());

            $completeSite = count(Site::where('project_id', $project->project_id)->where('completion_status', 'Completed')->get());
            //Date Count
            $now = time(); // or your date as well
            $taskFor = strtotime($project->task_for);
            $datediff = $now - $taskFor;
            $showDayCount = round($datediff / (60 * 60 * 24));

            //echo $project->project_id. '-' .$totalSite. '-'. $completeSite. '|'. round(($completeSite*100)/$totalSite) .'<br/>';

            $html .= '</tr>';
            $html .= '<tr align="center">';
            $html .= '<td>' .$project->code . '</td>';
            $html .= '<td>' .\App\Models\User::where('id', $project->manager)->first()->name . '</td>';
            $html .= '<td>' .$siteCode. '</td>';
            $html .= '<td>' .$showDayCount. ' Days'. '</td>';
            //$html .= '<td>' . $project->task_name. '</td>';
            $html .= '<td>' . round(($completeSite*100)/$totalSite).'%</td>';
            $html .= '</tr>';
        }
        $emailAddress = 'anowar@mtsbd.net';
        return  \Tritiyo\Task\Helpers\MailHelper::send($html, 'Weekly Report of Complete Site of Project', $emailAddress);
    }
}
