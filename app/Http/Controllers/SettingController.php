<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\Setting\SettingInterface;
use Illuminate\Http\Request;
use Validator;

class SettingController extends Controller
{
    /**
     * @var SettingInterface
     */
    private $setting;

    /**
     * SettingController constructor.
     * @param SettingInterface $setting
     */
    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->setting->getAll();
        return view('settings.index', ['settings' => $settings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'settings' => 'required'
            ]
        );

        // process the login
        if ($validator->fails()) {
            return redirect('routelists.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $attributes = [
                'name' => $request->name,
                'settings' => $request->settings
            ];

            try {
                $setting = $this->setting->create($attributes);
                return view('settings.create')->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return view('settings.create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    /**
     * Extra Methods
     * @param Request $request
     */

    public function global(Request $request, $id)
    {

        if (isset($request->name)) {

            $json = array(
                'company_name' => $request->company_name,
                'company_slogan' => $request->company_slogan,
                'address' => $request->address,
                'company_phone' => $request->company_phone,
                'company_email' => $request->company_email,
                'company_website' => $request->company_website
            );

            $attributes = [
                'name' => $request->name,
                'settings' => json_encode($json)
            ];

            //dd($attributes);
            $userupdate = $this->setting->update($id, $attributes);
            $setting = $this->setting->getById($id);
            if ($userupdate == true) {
                return view('settings.global', ['setting' => $setting, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $setting = $this->setting->getById($id);
            return view('settings.global', ['setting' => $setting, 'id' => $id]);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function payment(Request $request, $id)
    {

        if (isset($request->name)) {

            $json = array(
                'time_zone' => $request->time_zone,
                'requisition_start' => $request->requisition_start,
                'requisition_end' => $request->requisition_end,
                'requisition_approval_start' => $request->requisition_approval_start,
                'requisition_approval_end' => $request->requisition_approval_end,
                'bill_start' => $request->bill_start,
                'bill_end' => $request->bill_end,
                'bill_approval_start' => $request->bill_approval_start,
                'bill_approval_end' => $request->bill_approval_end
            );

            $attributes = [
                'name' => $request->name,
                'settings' => json_encode($json)
            ];

            //dd($attributes);
            $userupdate = $this->setting->update($id, $attributes);
            $setting = $this->setting->getById($id);
            if ($userupdate == true) {
                return view('settings.payment', ['setting' => $setting, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $setting = $this->setting->getById($id);
            return view('settings.payment', ['setting' => $setting, 'id' => $id]);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function time(Request $request, $id)
    {

        if (isset($request->name)) {

            $json = array(
                'time_zone' => $request->time_zone,
              /*
                'requisition_start' => $request->requisition_start,
                'requisition_end' => $request->requisition_end,
                'requisition_approval_start' => $request->requisition_approval_start,
                'requisition_approval_end' => $request->requisition_approval_end,
                'bill_start' => $request->bill_start,
                'bill_end' => $request->bill_end,
                'bill_approval_start' => $request->bill_approval_start,
                'bill_approval_end' => $request->bill_approval_end
                */
              'task_creation_end' => $request->task_creation_end,
              'proof_submission_end' => $request->proof_submission_end,
              'approval_time_end' => $request->approval_time_end,
              'requsition_submission_manager_end' => $request->requsition_submission_manager_end,
              'requsition_submission_cfo_end' => $request->requsition_submission_cfo_end,
            );

            $attributes = [
                'name' => $request->name,
                'settings' => json_encode($json)
            ];

            //dd($attributes);
            $userupdate = $this->setting->update($id, $attributes);
            $setting = $this->setting->getById($id);
            if ($userupdate == true) {
                return view('settings.time', ['setting' => $setting, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $setting = $this->setting->getById($id);
            return view('settings.time', ['setting' => $setting, 'id' => $id]);
        }

    }

    //Email
    public function email(Request $request, $id)
    {
//        dd($request->all());

        if (isset($request->name)) {

            $json = array(
                'email_address' => $request->email_address,
            );

            $attributes = [
                'name' => $request->name,
                'settings' => json_encode($json)
            ];

            //dd($attributes);
            $userupdate = $this->setting->update($id, $attributes);
            $setting = $this->setting->getById($id);
            if ($userupdate == true) {
                return view('settings.email', ['setting' => $setting, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $setting = $this->setting->getById($id);
            return view('settings.email', ['setting' => $setting, 'id' => $id]);
        }

    }
    
    
    //Other
        public function other(Request $request, $id)
    {
//        dd($request->all());

        if (isset($request->project_lock_percentage)) {

            $json = array(
                'project_lock_percentage' => $request->project_lock_percentage,
               	'cfo_restriction' => $request->cfo_restriction,
            );

            $attributes = [
                //'name' => $request->name,
                'settings' => json_encode($json)
            ];

            //dd($attributes);
            $userupdate = $this->setting->update($id, $attributes);
            $setting = $this->setting->getById($id);
            if ($userupdate == true) {
                return view('settings.other', ['setting' => $setting, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $setting = $this->setting->getById($id);
            return view('settings.other', ['setting' => $setting, 'id' => $id]);
        }

    }
    
    
    
    
    
    
}
