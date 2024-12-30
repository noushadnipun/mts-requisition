<?php
Route::get('/run-script', function(){
    $trb = DB::table('tasks_requisition_bill')->select('id', 'task_id')->get();
    //dd($trb);
  /*
    foreach($trb as $data){
        $run = DB::select("
        
UPDATE `tasks_requisition_bill` SET  `beba_amount` =

                        (SELECT
                                SUM(
                                    IFNULL(`material_amount_total`, 0) +
                                    IFNULL(`vehicle_rent_total`, 0)   +
                                    IFNULL(`task_purchase_breakdown`, 0)  +
                                    IFNULL(`task_transport_breakdown`, 0)  +
                                    IFNULL(`regular_total`, 0)
                            ) AS mm

                            FROM (
                                SELECT
                                sum(material_amount) AS material_amount_total,
                                (
                                    SELECT sum(vehicle_rent) AS vehicle_rent_total
                                    FROM tasks_requisition_bill, JSON_TABLE(bill_edited_by_accountant, '$.task_vehicle[*]'
                                                                            COLUMNS (vehicle_rent VARCHAR(255) PATH '$.vehicle_rent')) task_vehicle
                                    WHERE tasks_requisition_bill.task_id = $data->task_id
                                ) AS vehicle_rent_total,
                                (
                                    SELECT sum(pa_amount) AS purchase_total
                                    FROM tasks_requisition_bill, JSON_TABLE(bill_edited_by_accountant, '$.task_purchase_breakdown[*]'
                                                                            COLUMNS (pa_amount VARCHAR(255) PATH '$.pa_amount')) task_purchase_breakdown
                                    WHERE tasks_requisition_bill.task_id = $data->task_id
                                ) AS task_purchase_breakdown,
                                (
                                    SELECT sum(ta_amount) AS transport_total
                                    FROM tasks_requisition_bill, JSON_TABLE(bill_edited_by_accountant, '$.task_transport_breakdown[*]'
                                                                            COLUMNS (ta_amount VARCHAR(255) PATH '$.ta_amount')) task_transport_breakdown
                                    WHERE tasks_requisition_bill.task_id = $data->task_id
                                ) AS task_transport_breakdown,
                                (
                                    SELECT (da_amount + other_amount + labour_amount) AS regular_total_amount FROM (
                                        SELECT
                                        bill_edited_by_accountant->>'$.task_regular_amount.da.da_amount' AS da_amount,
                                        bill_edited_by_accountant->>'$.task_regular_amount.other.other_amount' AS other_amount,
                                        bill_edited_by_accountant->>'$.task_regular_amount.labour.labour_amount' AS labour_amount
                                        FROM tasks_requisition_bill WHERE task_id = $data->task_id
                                    ) AS hhhmm
                                ) AS regular_total

                                FROM tasks_requisition_bill,
                                JSON_TABLE(bill_edited_by_accountant, '$.task_material[*]' COLUMNS (material_amount VARCHAR(255) PATH '$.material_amount')) task_material
                                WHERE tasks_requisition_bill.task_id = $data->task_id

                            ) AS qwer
                        )
                        WHERE task_id = $data->task_id

        ");
        //return $run;
    }
    */
})->name('run.php.script');
