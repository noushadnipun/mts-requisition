<?php

namespace App\Http\Controllers;

use App\Exports\MailAttachment;
use Illuminate\Http\Request;
use App\Helpers\Mail;

use Maatwebsite\Excel\Facades\Excel;
use \Tritiyo\Site\Models\Site;
use \Tritiyo\Task\Models\TaskSite;
use \Tritiyo\Task\Helpers\MailHelper;
use \Tritiyo\Project\Models\Project;
use \Tritiyo\Project\Helpers\ProjectHelper;
use App\Models\User;
use DB;

use Carbon\Carbon;

use App\Models\Setting;
use App\Repositories\Setting\SettingInterface;

class MailingController extends Controller
{
    //Get Data
    public function user($manager_id)
    {
        return User::where('id', $manager_id)->first();
    }

    public function projectData($project_id)
    {
        return Project::where('id', $project_id)->first();
    }

    //Accounts, CFO, Finance Email
    public function afcMail()
    {
        $getSettingMail = Setting::where('id', 4)->first()->settings;
        $getSettingMailAddress = json_decode($getSettingMail)->email_address;
        return explode(' | ', $getSettingMailAddress);
    }

    public function attachment($arr, $filename)
    {
        return Excel::store(new MailAttachment($arr), $filename . '.xls');
    }


    //End ID


    public function projectBudgetUsage($percentage, $rangeTop)
    {
        /**
         * Need to send a mail about 50% usage of the budget assigned to a specific project,
         * Need to send a mail about 75% usage of the budget assigned to a specific project,
         * Need to send a mail about 90% usage of the budget assigned to a specific project,
         * Need to send a mail about 95% usage of the budget assigned to a specific project and its to notify them that they cant create any more task against that project
         * to: manager, cfo, finance
         */


        /**
         *
         * > 50 && < 74
         * > 75 && < 89
         * > 90 && < 94
         *
         */
        //Run cron every 1 hour


        $projects = Project::get();

        foreach ($projects as $key => $project) {
            $total = (int)ProjectHelper::current_range_budgets($project->id);
            $used = (int) ProjectHelper::current_range_used_budgets($project->id);


            if ($total > 0) {
                $getPercent = ($used * 100) / $total;
                $newGetPercent = (int)round($getPercent, 2);
            } else {
                $newGetPercent = 0;
            }

            $percentageInt = (int)$percentage;
            $remain = $total - $used;

            if (($percentageInt <= $newGetPercent) && ($newGetPercent < (int) $rangeTop)) {
                $cureentrangeid = ProjectHelper::current_range_id($project->id);

                $site = \Tritiyo\Site\Models\Site::where('project_id', $project->id)->whereNull('completion_status')->orWhereIn('completion_status', ['Completed', 'Running'])->where('range_ids', $cureentrangeid)->get();
                $completedSite = \Tritiyo\Site\Models\Site::where('project_id', $project->id)->where('completion_status', 'Completed')->where('range_ids', $cureentrangeid)->get();
                $runningSite = \Tritiyo\Site\Models\Site::where('project_id', $project->id)->where('completion_status', 'Running')->where('range_ids', $cureentrangeid)->get();
                $notStarted =  \Tritiyo\Site\Models\Site::where('project_id', $project->id)->whereNull('completion_status')->where('range_ids', $cureentrangeid)->get();
				
				//dd($site);
                //dump($site);
                $total_site = [
                    ['Total Budget', $total]
                ];              
                $budget_used = [
                  	['Budget Used', $used, ['background' => '#3273dc', 'color' => '#fff']]
                ];
                $remain = [
                  	['Remain Balance', $remain, ['background' => '#278e4b', 'color' => '#fff']],
                ];
                $not_started = [
                  	['Not Started', count($notStarted), ['background' => 'red', 'color' => '#fff']],
                ];
                 
                $tableStyle = 'xwidth="250" style="width: 98% !important;"';
              	
               $projectLockPercent = (int) \Tritiyo\Project\Helpers\ProjectHelper::projectLockPercentage(); 
              
              if($newGetPercent >= $projectLockPercent ){
              	  $text = 'Dear Concern, <br> You have used ' . $newGetPercent . '% of your allocated Budget. Now you can not create any more task for this project. Please contact with CFO. <br>';
              } else {
                	$text = 'Dear Concern, <br> You have used ' . $newGetPercent . '% of your allocated Budget. Please spent in calculative way as the savings can give you a higher KPI. Pleasse have the breakdown below <br>';
              }


                $projectManager = User::where('id', $project->manager)->first();

                $html = Mail::textMessageGenerator($text);
                $html .= Mail::textMessageGenerator('Project Name: ' . $project->name);
                $html .= Mail::textMessageGenerator('Project Manager: ' . $projectManager->name);
              
                //$html .= Mail::blockGenerator($block);
                
              
              	$xyz = 'style="vertical-align: top;"';
              
              	$html .= '<table style="width: 100%;">';
              	$html .= '<tr>';
                        $html .= '<td '. $xyz .'>';
                        $html .= Mail::blockGenerator($total_site);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::blockGenerator($budget_used);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::blockGenerator($remain);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::blockGenerator($not_started);
                        $html .= '</td>';
                 $html .= '</tr>';
              
                $html .= '<tr>';
                        $html .= '<td '. $xyz .'>';
                        $html .= Mail::tableGenerator($site, ['Total - ' . count($site), 'Location'], ['site_code', 'location'], false, $tableStyle);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::tableGenerator($completedSite, [' Completed - ' . count($completedSite), 'Location'], ['site_code', 'location'], false,  $tableStyle);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::tableGenerator($runningSite, [' Running - ' . count($runningSite), 'Location'], ['site_code', 'location'], false, $tableStyle);
                        $html .= '</td><td '. $xyz .'>';
                        $html .= Mail::tableGenerator($notStarted, [' Not Started - ' . count($notStarted), 'Location'], ['site_code', 'location'], false, $tableStyle);
                        $html .= '</td>';
                $html .= '</tr>';
              	$html .= '</table>';
              
              
                //$html .= Mail::tableGenerator($site, ['Total - ' . count($site), 'Location'], ['site_code', 'location'], false, $tableStyle);
                //$html .= Mail::tableGenerator($completedSite, [' Completed - ' . count($completedSite), 'Location'], ['site_code', 'location'], false,  $tableStyle);
                //$html .= Mail::tableGenerator($runningSite, [' Running - ' . count($runningSite), 'Location'], ['site_code', 'location'], false, $tableStyle);
                //$html .= Mail::tableGenerator($notStarted, [' Not Started - ' . count($notStarted), 'Location'], ['site_code', 'location'], false, $tableStyle);

                $subject = 'Project Budget Spend ' . $newGetPercent . '%';
                $emailAddress = $projectManager->email;
                MailHelper::send($html, $subject, $emailAddress);
				//return  $html;
            } else {
                //return 'false';
            }


        }

    }


    public function siteInclusion()
    {
        /**
         * Need to send a mail about new site inclusion in any project once in a day, project wise individual and all individual to finance
         * to: manager, cfo, finance
         */
        $sentMail = [];
        $siteProject = \Tritiyo\Site\Models\Site::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->groupBy('project_id')->get();
        foreach ($siteProject as $key => $project) {
            $sites = \Tritiyo\Site\Models\Site::where('project_id', $project->project_id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->get();

            $projectName = $this->projectData($project->project_id)->name;
            $managerID = $this->projectData($project->project_id)->manager;
            $managerEmailAddress = $this->user($managerID)->email;

            $emailAddress = $managerEmailAddress;
            $subject = 'New Sites had been added';

            $text = 'Dear Concern, <br> New Sites had been added to ' . $projectName . '. Please see the details below';

            $html = Mail::textMessageGenerator($text);
            $html .= Mail::tableGenerator($sites, ['Site Code', 'Location'], ['site_code', 'location'], 'width: 100%');

            MailHelper::send($html, $subject, $emailAddress);
        }

        //For Accounts CFO Finance
        $siteProjectafc = \Tritiyo\Site\Models\Site::join('projects', 'projects.id', 'sites.project_id')
            ->join('users', 'projects.manager', 'users.id')
            ->select('sites.*', 'projects.name as project_name', 'users.name as manager')
            ->whereDate('sites.created_at', date('Y-m-d'))->orderBy('sites.id', 'desc')->get();

        $afctext = 'Dear Concern, <br> New Sites had been added . Please see the details below';

        $afc = Mail::textMessageGenerator($afctext);
        $afc .= Mail::tableGenerator($siteProjectafc, ['Project Name', 'Site Code', 'Assigned'], ['project_name', 'site_code', 'manager'], 'width: 100%');

        $emailAddress = $this->afcMail();
        MailHelper::send($afc, $subject, $emailAddress, false);

    }


    public function siteTaskLimit()
    {
        /**
         * Need to send a mail about the task creation limit that he has crossed the limit which is
         * 4 task in a site and he cant create any more task against this site
         * to: manager, cfo, finance
         *
         *
         *
         * SELECT * FROM (
         *
         * SELECT id, project_id, (
         * SELECT manager FROM projects WHERE projects.id = sites.project_id) AS manager, task_limit, (task_limit -1) AS lessLimit, (SELECT count(*) AS totalof125 FROM (
         * SELECT * FROM `tasks_site` WHERE site_id = sites.id GROUP BY site_id, task_id ) AS qq
         * ) as totalCreatedTask
         * FROM `sites`
         *
         * ) AS mm WHERE mm.lessLimit = mm.totalCreatedTask
         *
         */

        $limitReached = DB::SELECT('SELECT * FROM (

            SELECT id, project_id,site_code, (
            SELECT manager FROM projects WHERE projects.id = sites.project_id) AS manager, task_limit, (task_limit -1) AS lessLimit, (SELECT count(*) AS totalof125 FROM (
                    SELECT * FROM `tasks_site` WHERE site_id = sites.id GROUP BY site_id, task_id ) AS qq
            ) as totalCreatedTask
            FROM `sites`

        ) AS mm WHERE mm.lessLimit = mm.totalCreatedTask');

        $managerBasedSites = [];
        foreach ($limitReached as $key => $val) {
            $currentManager = $val->manager;
            $managerBasedSites[$currentManager][] = (object)[
                'site_id' => $val->id,
                'site_code' => $val->site_code,
                'project_id' => $val->project_id,
                'manager' => $val->manager,
                'task_limit' => $val->task_limit,
                'lessLimit' => $val->lessLimit,
                'totalCreatedTask' => $val->totalCreatedTask,
            ];

        }

        //dump($managerBasedSites);
        foreach ($managerBasedSites as $data) {
            $html = [];
            $subject = '';
            $emailAddress = '';
            foreach ($data as $key => $val) {
                //dump($value);
                if ($val->totalCreatedTask == $val->lessLimit) {
                    $text = 'Dear Concern, <br> You have exceeded limit of task for the below sites. Those sites are locked as you can\'t create any task. Please talk to CFO for the assistance';

                    $html = Mail::textMessageGenerator($text);
                    $html .= Mail::tableGenerator($data, ['Site Code', 'Total Task', 'Task Limit'], ['site_code', 'totalCreatedTask', 'task_limit'], 'width: 100%');
                    $subject = 'Exceeded limit of task';
                    $emailAddress = $this->user($val->manager)->email;

                }
            }
            MailHelper::send($html, $subject, $emailAddress);
        }

    }

    public function activityOnSite($day)
    {
        /**
         * Need to send a mail about the sites that have been active from past 10 days but still there is not any task created against this site,
         */
        /**
         * Need to send a mail about the sites that are running from past 10 days but still it is not marked as completed.
         */
      
        $date = date('Y-m-d', strtotime("-".$day." days"));
        $sites = Site::leftjoin('tasks_site', 'tasks_site.site_id', '=', 'sites.id')
            ->select('sites.*', 'tasks_site.site_id')
            ->groupBy('sites.id')
            ->where('tasks_site.site_id', Null)
          	->whereNull('completion_status')
            ->whereDate('sites.created_at', '<=', $date)->latest()->get();
        $activity = [];
        foreach ($sites as $site) {
            $manager = $site->pm;
            $activity[$manager][] = (object)[
                'site_code' => $site->site_code,
                'project' => $this->projectData($site->project_id)->name,
                'created_at' => $site->created_at->format('Y-m-d'),
                'manager' => $this->user($site->pm)->name,
                'manager_id' => $site->pm,
             	'completion_status'  => $site->completion_status, 
             	 'tasks_site'   => $site->site_id,
            ];
        }
      
      dd($activity);

      
        foreach ($activity as $act) {
            $html = '';
            $emailAddress = '';
          if($day == '14'){
         		$forText = 'by today. Otherwise site will be locked.';
            } else {
          			$forText =  'for site completion.';
          	}
          	
          
            foreach ($act as $data) {
                $text = 'Dear Concern, <br> Below sites are the sites that you haven\'t created any task from last '.$day. ' days. Please try to create task with the following sites '.$forText;
                $html = Mail::textMessageGenerator($text);
                $html .= Mail::tableGenerator($act, ['Site Code', 'Created At', 'Manager', 'Project'], ['site_code', 'created_at', 'manager', 'project'], 'width: 100%', false, 'serial');
                $emailAddress = $this->user($data->manager_id)->email;
            }
            $subject = 'No task has been created from past '.$day.' days';
            
          
          //MailHelper::send($html, $subject, $emailAddress);
          

        }
	return $html;
//
    }

    public function noActivityOnSiteToDisable()
    {
        /**
         * after 15 days and he cant create any more task against this sites will be locked
         */
        /**
         * after 15 days this sites will be locked and you cant crate any task against it
         */
        $today = date("Y-m-d");
        $after15Days = date("Y-m-d", strtotime("+15 day"));

        /***
         *
         * DB::SELECT('SELECT * FROM (
         *
         * SELECT id, project_id,site_code, (
         * SELECT manager FROM projects WHERE projects.id = sites.project_id) AS manager, task_limit, (task_limit -1) AS lessLimit, (SELECT count(*) AS totalof125 FROM (
         * SELECT * FROM `tasks_site` WHERE site_id = sites.id GROUP BY site_id, task_id ) AS qq
         * ) as totalCreatedTask
         * FROM `sites`
         *
         * ) AS mm WHERE mm.lessLimit = mm.totalCreatedTask');
         */


        $sites = Site::join('projects', 'sites.project_id', 'projects.id')
            ->join('tasks_site', 'tasks_site.site_id', 'sites.id')
            ->select('sites.*', 'projects.id', 'projects.manager')
            ->whereBetween('sites.created_at', [$today, $after15Days])
            ->groupBy('sites.id')
            ->get();

        $managerBasedSites = [];
        foreach ($sites as $key => $val) {
            $currentManager = $val->manager;
            $managerBasedSites[$currentManager][] = (object)[
                'site_id' => $val->id,
                'site_code' => $val->site_code,
                'project_id' => $val->project_id,
                'manager' => $val->manager,
                'task_limit' => $val->task_limit,
                'lessLimit' => $val->lessLimit,
                'totalCreatedTask' => $val->totalCreatedTask,
            ];

        }
		
      		
            /*
          		foreach($sites as $site){
                  //$site->id
                    		$data = \Tritiyo\Site\Models\Site::find(47);
                  			$data->completion_status = 'Discard';
                  			$data->save();      
                    }
                    */
          
      
        foreach ($managerBasedSites as $data) {
            $html = [];
            $subject = '';
            $emailAddress = '';
            foreach ($data as $key => $val) {
                //dump($value);
                if ($val->totalCreatedTask == $val->lessLimit) {
                    $text = 'Dear Concern, <br> You have exceeded limit of task for the below sites. Those sites are locked as you can\'t create any task. Please talk to CFO for the assistance';

                    $html = Mail::textMessageGenerator($text);
                    $html .= Mail::tableGenerator($data, ['Site Code', 'Total Task', 'Task Limit'], ['site_code', 'totalCreatedTask', 'task_limit'], 'width: 100%');
                    $subject = 'Exceeded limit of task';
                    $emailAddress = $this->user($val->manager)->email;

                }
            }
            MailHelper::send($html, $subject, $emailAddress);
        }
    }

    public function notYetInvoiceSubmitted()
    {
        /**
         * Need to send a mail about the sites that are completed from past 1 days but still there is no invoice against this sites, please submit the invoice.
         */
        /**
         * this email will be sent on every two days later
         */
        $invoice = DB::SELECT("SELECT * FROM (
                                SELECT id, project_id, site_code, pm, completion_status, completed_date, (SELECT invoice_date FROM site_invoices WHERE site_id = sites.id ORDER BY site_invoices.id DESC LIMIT 0,1) AS invoice_date
                                FROM `sites` WHERE completion_status = 'Completed'
                        ) AS mm WHERE invoice_date IS NULL  ORDER BY mm.pm DESC");
       //) AS mm WHERE pm = mm.pm AND invoice_date IS NULL");

        $managerBasedSites = [];
      

        foreach ($invoice as $val) {
              $currentManager = $val->pm;
              $managerBasedSites[$currentManager][] = (object) [              
                  'site_code' => $val->site_code,
                  'project_name' => $this->projectData($val->project_id)->name,
                  'manager' => $val->pm,
                  'manager_name' => $this->user($val->pm)->name,
                  'completion_status' => $val->completion_status,
                  'completed_date' => $val->completed_date
              ];
        }
      	
    	//dd($managerBasedSites);
        foreach ($managerBasedSites  as   $data) {          	
            $html = [];
            $subject = '';
            $emailAddress = '';
            foreach ($data as $key => $val) {
                //dump($key);        	
                $text = 'Dear Concern, <br> Please check the below sites which are completed but still not submitted any invoice against them. Please submit invoice as soon as possible.';
                $html = Mail::textMessageGenerator($text);
                $html .= Mail::tableGenerator(
                  							$data, 
                                              ['Site Code', 'Project Name', 'Manager Name', 'Completion Status', 'Completion Date'], 
                                              ['site_code', 'project_name', 'manager_name', 'completion_status', 'completed_date' ], 
                                              'width: 100%', false, 'serial'
                                        );
                $subject = 'Not yet invoice submited';
                $emailAddress = $this->user($val->manager)->email;

            }
            MailHelper::send($html, $subject, $emailAddress);
          
          	//return $html;
        }
    }

    public function nonEngagedEmployeesList($day)
    {
        /**
         * Need to send a mail about the employees that are not being used in any task from past 5 days in a row. please engage them in any activity
         */
        $resourceNotUsed = DB::SELECT("
                        SELECT * FROM (
                            SELECT resource_id, task_for FROM (
                                SELECT task_id, resource_id, task_for FROM `tasks_site` WHERE task_for BETWEEN DATE_SUB(NOW(), INTERVAL '$day' day) AND CURDATE() GROUP BY resource_id
                                UNION
                                SELECT id, site_head, task_for FROM `tasks` WHERE task_for BETWEEN DATE_SUB(NOW(), INTERVAL '$day' day) AND CURDATE()
                            ) AS mm
                            UNION
                                SELECT id AS resource_id, NULL AS task_for  FROM users WHERE users.role = 2
                        ) AS www GROUP BY www.resource_id
                        ");
        $nonUsed = [];
        $used = [];

        foreach ($resourceNotUsed as $data) {
            //dump($data->resource_id);
            if (!empty($data->resource_id) && $data->task_for == NULL) {
                $nonUsed[] = (object)[
                    'name' => '<a target="_blank" href="' . route('hidtory.user', $data->resource_id) . '">' . User::where('id', $data->resource_id)->first()->name . '</a>' ?? NULL,
                  	 'department' => User::where('id', $data->resource_id)->first()->department  ?? NULL,
                   'designation' =>DB::table('designations')->where('id',  User::where('id', $data->resource_id)->first()->designation)->first()->name  ?? NULL,
                ];
            } else {
                //$used[] = $data->resource_id . '-' . User::where('id', $data->resource_id)->first()->name ?? NULL;
            }
        }
			//return $nonUsed;
        $text = 'Dear Concern, <br> Below employees that are not being used in any task from past '.$day.' days in a row. please engage them to any activity. Otherwise their termination possibilities will increase.';

        $html = Mail::textMessageGenerator($text);
        $html .= Mail::tableGenerator($nonUsed, ['Name', 'Department', 'Designation'], ['name', 'department', 'designation'], 'width: 100%; text-align: left;');
        $subject = 'List of Employees those are Not Engage in any activity from last '.$day.' days';
        $emailAddress = \App\Models\User::select('email')->whereIn('role', [3, 4, 5,7])->get();
        MailHelper::send($html, $subject, $emailAddress, false);
	//return $html;
    }

    public function usagesOfEmployee()
    {
        /**
         * Need to send a mail about the Monthly resource usage report, will be sent this on monthly basis, first day of every month.
         */
        //$lastMonth =  Carbon::now()->subMonth(2)->format('m');
        $startdate = Carbon::now()->subMonth(1)->format('Y-m-d');
       $month = Carbon::now()->subMonth(1)->format('F');
        $enddate = Carbon::now()->yesterday()->format('Y-m-d'); 
        /*
            SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE task_for BETWEEN DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) AND resource_id IS NOT NULL GROUP BY resource_id
                                        UNION
                                        SELECT id, site_head, 'Used' AS used FROM `tasks`  where task_for BETWEEN DATE_ADD(CURDATE(), INTERVAL - 1 MONTH)  AND site_head IS NOT NULL
          */
        $employeeUsage = DB::select("
                        SELECT * FROM (
                            SELECT resource_id, used FROM (
                                SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE (task_for BETWEEN'$startdate' AND '$enddate' ) AND resource_id IS NOT NULL GROUP BY resource_id
                                UNION
                                SELECT id, site_head, 'Used' AS used FROM `tasks`  where (task_for BETWEEN'$startdate' AND '$enddate' )  AND site_head IS NOT NULL
                            ) AS mm WHERE mm.resource_id IS NOT NULL
                            UNION
                                SELECT id AS resource_id, NULL AS used   FROM users WHERE users.role = 2
                        ) AS www GROUP BY www.resource_id
        ");

        //dd($employeeUsage);
		//dd($month);

        $used = [];
        foreach ($employeeUsage as $data) {
            //dump($data->resource_id);
            if (!empty($data->resource_id) && $data->used == NULL) {
                $nonUsed[] = (object)[
                    'name' => '<a target="_blank" href="' . route('hidtory.user', $data->resource_id) . '">' . User::where('id', $data->resource_id)->first()->name . '</a>' ?? NULL,
                ];
            } else {

                //dd($startdate);
                $countSiteHead = \Tritiyo\Task\Models\Task::where('site_head', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->groupBy('task_for')->get();
              	//dd($countSiteHead);
                $countResource = \Tritiyo\Task\Models\TaskSite::where('resource_id', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->where('task_for', '!=', NULL)->groupBy('task_for')->get();
              	//dd($countResource);
              
                $used[] = (object)[
                    'id' => $data->resource_id,
                    'designation' => \App\Models\User::where('id', $data->resource_id)->first()->designation ?? NULL,
                    'designationName' => DB::table('designations')->where('id', \App\Models\User::where('id', $data->resource_id)->first()->designation)->first()->name ?? NULL,
                    'name' => '<a target="_blank" href="' . route('hidtory.user', $data->resource_id) . '">' . User::where('id', $data->resource_id)->first()->name . '</a>' ?? NULL,
                    'department' => \App\Models\User::where('id', $data->resource_id)->first()->department ?? NULL,
                    'count' => count($countSiteHead) + count($countResource),
                    'siteHead' => count($countSiteHead),
                    'Resource' => count($countResource),
                ];
            }
        }

        $text = 'Dear Concern, <br>Please have the employee usage for the month of '.$month.'. Please mind that the lower usage count employees are in the risk of termination. Please talk to HR and try to  increase  activity of them otherwise they will be terminated. ';

        $html = Mail::textMessageGenerator($text);
        $html .= Mail::tableGenerator($used, ['Name', 'Designation', 'Department', 'Site Head', 'Resource', 'Total'], ['name', 'designationName', 'department', 'siteHead', 'Resource', 'count'], 'width: 100%; text-align: left;');
        $subject = 'Monthly Count Of Employees Usage || '.$month;
        $emailAddress = \App\Models\User::select('email')->whereIn('role', [3, 4, 5])->get();
        MailHelper::send($html, $subject, $emailAddress);
    }


    public function yesterdayUsagesOfEmployee()
    {
        /**
         * mail send to HR
         * Everyday which resource usage.
         */
        //$lastMonth =  Carbon::now()->subMonth(2)->format('m');
        $startdate = Carbon::now()->yesterday()->format('Y-m-d');
        $enddate = date('Y-m-d');
        /*
            SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE task_for BETWEEN DATE_ADD(CURDATE(), INTERVAL - 1 MONTH) AND resource_id IS NOT NULL GROUP BY resource_id
                                        UNION
                                        SELECT id, site_head, 'Used' AS used FROM `tasks`  where task_for BETWEEN DATE_ADD(CURDATE(), INTERVAL - 1 MONTH)  AND site_head IS NOT NULL
          */
        $employeeUsage = DB::select("
                          SELECT * FROM (
                              SELECT resource_id, used FROM (
                                  SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE task_for  = '$startdate' AND resource_id IS NOT NULL GROUP BY resource_id
                                  UNION
                                  SELECT id, site_head, 'Used' AS used FROM `tasks`  where task_for = '$startdate'  AND site_head IS NOT NULL
                              ) AS mm WHERE mm.resource_id IS NOT NULL
                              UNION
                                  SELECT id AS resource_id, NULL AS used FROM users WHERE users.role = 2
                          ) AS www WHERE www.used IS NOT NULL GROUP BY www.resource_id
                        
        ");

        //dd($employeeUsage);


        $used = [];
        foreach ($employeeUsage as $data) {
            
            //dump($data->resource_id);
            /**
          	if (!empty($data->resource_id) && $data->used == NULL) {
                $nonUsed[] = (object)[
                    'name' => '<a target="_blank" href="' . route('hidtory.user', $data->resource_id) . '">' . User::where('id', $data->resource_id)->first()->name . '</a>' ?? NULL,
                ];
            } else {
			**/
                //dd($startdate);
                $countSiteHead = \Tritiyo\Task\Models\Task::where('site_head', $data->resource_id)->where('task_for', $startdate)->groupBy('task_for')->get();
                $countResource = \Tritiyo\Task\Models\TaskSite::where('resource_id', $data->resource_id)->where('task_for', $startdate)->where('task_for', '!=', NULL)->groupBy('task_for')->get();
              
                $used[] = (object)[
                    'id' => $data->resource_id,
                    'designation' => \App\Models\User::where('id', $data->resource_id)->first()->designation ?? NULL,
                    'designationName' => DB::table('designations')->where('id', \App\Models\User::where('id', $data->resource_id)->first()->designation)->first()->name ?? NULL,
                    'name' => '<a target="_blank" href="' . route('hidtory.user', $data->resource_id) . '">' . User::where('id', $data->resource_id)->first()->name . '</a>' ?? NULL,
                    'department' => \App\Models\User::where('id', $data->resource_id)->first()->department ?? NULL,
                    'count' => count($countSiteHead) + count($countResource),
                    'siteHead' => count($countSiteHead),
                    'Resource' => count($countResource),
                ];
            /** } **/
        }
      
      	//dd($used);

        $text = 'Dear Concern, <br> Below employees that are  being used in ' . $startdate;

        $html = Mail::textMessageGenerator($text);
        $html .= Mail::tableGenerator($used, ['Name', 'Designation', 'Department', 'Site Head', 'Resource', 'Total'], ['name', 'designationName', 'department', 'siteHead', 'Resource', 'count'], 'width: 100%; text-align: left;', false, 'serial');
        $subject = 'List of Usage Employees of ' . $startdate;
        $emailAddress = \App\Models\User::select('email')->whereIn('role', [4,7])->get();
        //$emailAddress = 'nipun@tritiyo.com';

        //$this->attachment($used, $subject);
        //Excel::store(new MailAttachment($used), $subject.'.xlsx');
		
        MailHelper::send($html, $subject, $emailAddress, false);
      //MailHelper::send($html, $subject, 'nipun@tritiyo.com', false);
	    //return $html;
    }


    /**
     * Need to send a mail about the budget usage ratio for individual project on weekly basis, the ratio is between the total budget usage in the week vs
     * total site budget assigned against those sites. it will be named as budget usage high or low. it will be a weekly mail.
     */


    //out of cron
    //Need to send a mail about the active and inactive status of a project
    //Need to send a mail about the invoice submission update


    public function mailing(array $options = [])
    {
        $default = [
            'search_key' => null,
            'column' => !empty($field) ? $field : null,
            'sort_type' => !empty($type) ? $type : null,
            'limit' => 10,
            'offset' => 0
        ];
        $no = array_merge($default, $options);

    }

    /**
     * ALTER TABLE `sites` CHANGE `site_type` `site_type` ENUM('Fresh','Old','Recurring') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
     * ALTER TABLE `sites` ADD `manager` INT(11) NULL AFTER `user_id`;
     * ALTER TABLE `sites` ADD `completed_date` DATE NULL AFTER `completion_status`;
     * ALTER TABLE `sites` CHANGE `manager` `pm` INT NULL DEFAULT NULL;
     */
}




/**
 *
 * SELECT * FROM (
 * SELECT resource_id, task_for FROM (
 * SELECT task_id, resource_id, task_for FROM `tasks_site` WHERE task_for BETWEEN '2021-05-10' AND CURDATE() GROUP BY resource_id
 * UNION
 * SELECT id, site_head, task_for FROM `tasks` WHERE task_for BETWEEN '2021-05-10' AND CURDATE()
 * ) AS mm
 *
 * UNION
 * SELECT id AS resource_id, NULL AS task_for  FROM users WHERE users.role = 2
 * ) AS www GROUP BY www.resource_id
 */
