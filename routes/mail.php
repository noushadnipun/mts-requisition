<?php

use App\Http\Controllers\MailingController;

//per 24 hours
Route::get('project-budget/{percentage}-{rangeTop}', [MailingController::class, 'projectBudgetUsage'])->name('project.budget.percentage');

//per day
Route::get('site-inclusion/today', [MailingController::class, 'siteInclusion'])->name('site.inclusion.today');
//per day
Route::get('site-task-limit', [MailingController::class, 'siteTaskLimit'])->name('site.task.limit');

//per 10 days
Route::get('activity-on-site/{day}', [MailingController::class, 'activityOnSite'])->name('activity.on.site');

//per 15 days
Route::get('no-activity-site', [MailingController::class, 'noActivityOnSiteToDisable'])->name('no.activity.site');
//Per day
Route::get('no-invoice-submitted', [MailingController::class, 'notYetInvoiceSubmitted'])->name('no-invoice-submitted');

//per 5 days
Route::get('non-engaged-employeesList/{day}', [MailingController::class, 'nonEngagedEmployeesList'])->name('non-engaged-employeesList');


//per month
Route::get('usage-employee-monthly-report', [MailingController::class, 'usagesOfEmployee'])->name('usage-employee-monthly-report');


//per day
Route::get('yesterday-usage-employee-report', [MailingController::class, 'yesterdayUsagesOfEmployee'])->name('yesterday-usage-employee-report');

/*
//Cron for delete task if task create time is over
Route::get('/task-action-over', function(){
  //dd(Carbon\Carbon::yesterday());
  $getTask = \Tritiyo\Task\Models\Task::leftjoin('tasks_proof', 'tasks_proof.task_id', 'tasks.id')
  			 ->select('tasks.id', 'tasks.created_at')
    		 ->whereDate('tasks.created_at', Carbon\Carbon::today())
    		  ->whereNull('tasks_proof.task_id')
    		 ->get();
  
  foreach($getTask as $task){
  	$id =  $task->id;
    //\Tritiyo\Task\Models\Task::where('id', $id)->delete();
    //\Tritiyo\Task\Models\TaskMaterial::where('task_id', $id)->delete();
    //\Tritiyo\Task\Models\TaskVehicle::where('task_id', $id)->delete();
    //\Tritiyo\Task\Models\TaskSite::where('task_id', $id)->delete();
    //\Tritiyo\Task\Models\TaskStatus::where('task_id', $id)->delete();
  }
  
  //dd($getTask);
});

*/




