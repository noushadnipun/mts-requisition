<?php
if (!function_exists('view_details')) {

    function view_details_button($route, $id)
    {
        $html = '<a class="button is-small  is-fullwidth" href="' . route($route, $id) . '"><i class="fas fa-eye"></i>&nbsp;View Details</a>';
        return $html;
    }

}

if (!function_exists('requsition_buttons')) {
    /**
     * @param object $requisition
     * @param array $routes
     * @param $user_id
     * @param $requisition_id
     */
    function requisition_buttons(object $requisition, array $routes, $user_id, $requisition_id)
    {
        manager_requisition_buttons($requisition, $routes, $user_id, $requisition_id);
        cfo_requisition_buttons($requisition, $routes, $user_id, $requisition_id);
        accountant_requisition_buttons($requisition, $routes, $user_id, $requisition_id);
    }
}

if (!function_exists('bill_buttons')) {
    /**
     * @param object $bill
     * @param array $routes
     * @param $user_id
     * @param $bill_id
     */
    function bill_buttons(object $bill, array $routes, $user_id, $bill_id)
    {
        //dd($routes);
        manager_bill_buttons($bill, $routes, $user_id, $bill_id);
        cfo_bill_buttons($bill, $routes, $user_id, $bill_id);
        accountant_bill_buttons($bill, $routes, $user_id, $bill_id);
    }
}

if (!function_exists('requisition_bill_submit_button')) {
    function requisition_bill_submit_button($route, $requisitionid)
    {
        $html = '<h3 class="isCentered"><strong>Bill Part</strong></h3>';
        $html .= '<a class="button is-small  is-fullwidth is-info" href="' . route($route, $requisitionid) . '"><i class="fas fa-file"></i>&nbsp; Submit bill</a>';
        return $html;
    }
}


if (!function_exists('manager_requisition_buttons')) {
    function manager_requisition_buttons(object $requisition, array $routes, $user_id, $requisition_id)
    {
        //dump($requisition);
        $html = null;
        if ($requisition->manager_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;Manager Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">Manager Pending</a>';
            } elseif (auth()->user()->isManager($user_id)) {

                //dump(date('Y-m-d', strtotime("-1 days")));
                //dd(route('employeerequisitions.cfo_quickapprove'));
                $manager_approved_pending = \App\Models\EmployeeBill::where('project_manager_id', auth()->user()->id)
                    ->where('manager_approved', 'No')
                    ->whereDate('submitted_date', '<', date('Y-m-d', strtotime("-2 days")))
                    //->where('submitted_date', '>', \Carbon\Carbon::now()->subDays(2))
                    ->get();
                //dd($manager_approved_pending);
                if ($manager_approved_pending->count() > 0) {
                    $html .= '<a class="button is-small is-fullwidth is-warning" href="javascript:void(0)">Opps! Tons of Bill Pending</a>';
                } else {
                    if ($requisition->manager_edited_total_amount == null && $requisition->cfo_edited_total_amount == null && $requisition->accountant_edited_total_amount == null) {
                        $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["rmanager_quickapprove"], $requisition_id) . '">Approve Now</a>';
                    }
                    $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["rmanager_editandsave"], $requisition_id) . '">Edit and Save</a>';
                    $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["rmanager_tocfo"], $requisition_id) . '">Send to CFO</a>';
                }
            }
        }

        echo $html;
    }
}


if (!function_exists('cfo_requisition_buttons')) {
    function cfo_requisition_buttons(object $requisition, array $routes, $user_id, $requisition_id)
    {
        //dd(auth()->user()->isCFO($user_id)->role);
        $html = null;
        if ($requisition->cfo_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;CFO Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">CFO Pending</a>';
            } elseif (auth()->user()->isCFO($user_id)) {
                $manager_approved_pending = \App\Models\EmployeeBill::where('cfo_approved', 'No')
                    ->whereDate('submitted_date', '<', date('Y-m-d', strtotime("-2 days")))
                    ->get();
                //dd($manager_approved_pending);
                if ($manager_approved_pending->count() > 0) {
                    $html .= '<a class="button is-small is-fullwidth is-warning" href="javascript:void(0)">Opps! Tons of Bill Pending</a>';
                } else {
                    if ($requisition->manager_edited_total_amount == null && $requisition->cfo_edited_total_amount == null && $requisition->accountant_edited_total_amount == null) {
                        $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["rcfo_quickapprove"], $requisition_id) . '">Approve Now</a>';
                    }
                    $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["rcfo_editandsave"], $requisition_id) . '">Edit and Save</a>';
                    $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["rcfo_toaccountant"], $requisition_id) . '">Send to Accountant</a>';
                }
            }
        }

        echo $html;
    }
}

if (!function_exists('accountant_requisition_buttons')) {
    function accountant_requisition_buttons(object $requisition, array $routes, $user_id, $requisition_id)
    {
        $html = null;
        if ($requisition->accountant_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;Accountant Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">Accountant Pending</a>';
            } elseif (auth()->user()->isAccountant($user_id)) {
                if ($requisition->manager_edited_total_amount == null && $requisition->cfo_edited_total_amount == null && $requisition->accountant_edited_total_amount == null) {
                    $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["raccountant_quickapprove"], $requisition_id) . '">Approve Now</a>';
                }
                $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["raccountant_editandsave"], $requisition_id) . '">Edit and Save</a>';
                $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["raccountant_tofinal"], $requisition_id) . '">Final Save</a>';
            }
        }

        echo $html;
    }
}


if (!function_exists('manager_bill_buttons')) {
    function manager_bill_buttons(object $bill, array $routes, $user_id, $bill_id)
    {
        $html = null;
        if ($bill->manager_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;Manager Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">Manager Pending</a>';
            } elseif (auth()->user()->isManager($user_id)) {

                if ($bill->manager_edited_total_amount == null && $bill->cfo_edited_total_amount == null && $bill->accountant_edited_total_amount == null) {
                    $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["bmanager_quickapprove"], $bill_id) . '">Approve Now</a>';
                }
                $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["bmanager_editandsave"], $bill_id) . '">Edit and Save</a>';
                $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["bmanager_tocfo"], $bill_id) . '">Send to CFO</a>';
            }
        }

        echo $html;
    }
}


if (!function_exists('cfo_bill_buttons')) {
    function cfo_bill_buttons(object $bill, array $routes, $user_id, $bill_id)
    {
        $html = null;
        if ($bill->cfo_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;CFO Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">CFO Pending</a>';
            } elseif (auth()->user()->isCFO($user_id)) {
                if ($bill->manager_edited_total_amount == null && $bill->cfo_edited_total_amount == null && $bill->accountant_edited_total_amount == null) {
                    $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["bcfo_quickapprove"], $bill_id) . '">Approve Now</a>';
                }
                $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["bcfo_editandsave"], $bill_id) . '">Edit and Save</a>';
                $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["bcfo_toaccountant"], $bill_id) . '">Send to Accountant</a>';
            }
        }

        echo $html;
    }
}

if (!function_exists('accountant_bill_buttons')) {
    function accountant_bill_buttons(object $bill, array $routes, $user_id, $bill_id)
    {
        $html = null;
        if ($bill->accountant_approved == 'Yes') {
            $html .= '<a class="button is-small  is-fullwidth is-success"><i class="fas fa-check"></i>&nbsp;Accountant Approved</a>';
        } else {
            if (auth()->user()->isResource($user_id)) {
                $html .= '<a class="button is-small  is-fullwidth is-warning" href="javascript:void(0)">Accountant Pending</a>';
            } elseif (auth()->user()->isAccountant($user_id)) {
                if ($bill->manager_edited_total_amount == null && $bill->cfo_edited_total_amount == null && $bill->accountant_edited_total_amount == null) {
                    $html .= '<a class="button is-small is-fullwidth is-success" href="' . route($routes["baccountant_quickapprove"], $bill_id) . '">Approve Now</a>';
                }
                $html .= '<a class="button is-small is-fullwidth is-primary" href="' . route($routes["baccountant_editandsave"], $bill_id) . '">Edit and Save</a>';
                $html .= '<a class="button is-small is-fullwidth is-link" href="' . route($routes["baccountant_tofinal"], $bill_id) . '">Final Save</a>';
            }
        }

        echo $html;
    }
}
