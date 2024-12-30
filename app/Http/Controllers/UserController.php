<?php

namespace App\Http\Controllers;

use App\Helpers\Mail;
use App\Models\Designation;
use App\Models\User;
use App\Repositories\User\PermissionInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tritiyo\Site\Models\Site;
use Validator;

class UserController extends Controller
{

    /**
     * @var UserInterface
     */
    private $user;
    /**
     * @var PermissionInterface
     */
    private $permission;

    /**
     * UserController constructor.
     * @param UserInterface $user
     * @param PermissionInterface $permission
     */
    public function __construct(UserInterface $user, PermissionInterface $permission)
    {
        $this->user = $user;
        $this->permission = $permission;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->getAll();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
                'email' => 'required',
                'phone' => 'required',
                'employee_no' => 'required'
            ]
        );

        // process the login
        if ($validator->fails()) {
            return redirect('users.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $attributes = [
                'name' => $request->name,
                'email' => $request->email,
                'employee_no' => $request->employee_no,
                'username' => 'u' . $request->employee_no,
                'phone' => $request->phone,
                'emergency_phone' => $request->emergency_phone,
                'role' => $request->role,
                'department' => $request->department,
                'designation' => $request->designation,
                'password' => bcrypt('mtsbd123'),
            ];

            try {
                $user = $this->user->create($attributes);
                return view('users.create')->with(['status' => 1, 'message' => 'Successfully created user']);
            } catch (\Exception $e) {
                //dd($e->errorInfo[2]);
                $errormsg = $e->errorInfo[2];
                return view('users.create')->with(['status' => 0, 'message' => $errormsg]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function logout(Request $request)
    {
//        Auth::logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        Auth::logout();
        setcookie('loggedIn', false, -1, '/');
        setcookie('user', null, -1, '/');
        return redirect('/login');
    }

    public function search(Request $request)
    {
        if(!empty($request->key)) {
            $default = [
            'search_key' => $request->key ?? '',
            'limit' => 10,
            'offset' => 0
            ];
            $users = $this->user->getDataByFilter($default);
        } else {
            $users = $this->user->getAll();
        }
        return view('users.index', ['users' => $users]);
    }


    /** Extra Methods */
    //Route::any('users/basic_info', [UserController::class, 'basic_info'])->name('users.basic_info');
    //Route::any('users/contact_info', [UserController::class, 'contact_info'])->name('users.contact_info');
    //Route::any('users/user_photos', [UserController::class, 'user_photos'])->name('users.user_photos');
    //Route::any('users/user_permissions', [UserController::class, 'user_permissions'])->name('users.user_permissions');
    //Route::any('users/financial_info', [UserController::class, 'financial_info'])->name('users.financial_info');
    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function basic_info(Request $request, User $user, $id)
    {

        if (isset($request->basic_info)) {
            $validator = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required|min:11|max:11',
                    'employee_no' => 'required',
                    'emergency_phone' => 'min:11|max:11'
                ]
            );

            // process the login
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $attributes = [
                    'name' => $request->name,
                    'employee_no' => $request->employee_no,
                    'phone' => $request->phone,
                    'emergency_phone' => $request->emergency_phone,
                    'email' => $request->email,
                    'role' => $request->role,
                    'department' => $request->department,
                    'designation' => $request->designation
                ];

                $userupdate = $this->user->update($id, $attributes);
                $user = $this->user->getById($id);
                if ($userupdate == true) {
                    return view('users.basic_info', ['user' => $user, 'id' => $id, 'message' => 'Successfully saved']);
                }
            }
        } else {
            $user = $this->user->getById($id);
            return view('users.basic_info', ['user' => $user, 'id' => $id]);
        }

    }

    /**
     * @param Request $request
     * @param User $user
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact_info(Request $request, User $user, $id)
    {
        if (isset($request->contact_info)) {
            //dd($request);

            if($request->employee_status == 'Enroll') {
                $status_reason = 'Enroll';
            } else if($request->employee_status == 'Terminated') {
                $status_reason = 'Terminated';
            } else if($request->employee_status == 'Long Leave') {
                $status_reason = 'Long Leave';
            } else if($request->employee_status == 'Left Job') {
                $status_reason = 'Left Job';
            } else if($request->employee_status == 'On Hold') {
                $status_reason = 'On Hold';
            }

            $attributes = [
                'father' => $request->father,
                'mother' => $request->mother,
                'address' => $request->address,
                'postcode' => $request->postcode,
                'district' => $request->district,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'birthday' => $request->birthday,
                'alternative_email' => $request->alternative_email,
                'company' => $request->company,
                'company_address' => $request->company_address,
                'basic_salary' => $request->basic_salary,
                'join_date' => $request->join_date,
                'employee_status' => $request->employee_status,
                'employee_status_reason' => $status_reason ?? $request->employee_status_reason
            ];

            $userupdate = $this->user->update($id, $attributes);

            $user = $this->user->getById($id);

            if($request->employee_status){
                // Mail funvction
                $text = 'Dear Concern, <br>  Employee status has been updated.';
                $emplo = [];
                $emplo[] = (object)[
                    'name' => $user->name,
                    'department' => $user->department,
                    'designation' => Designation::where('id', $user->designation)->first()->name,
                    'employee_status' => $user->employee_status,
                    'employee_status_reason' => $status_reason ?? $request->employee_status_reason
                ];
                //dd($emplo);
                $html = Mail::textMessageGenerator($text);
                $html .= Mail::tableGenerator($emplo, ['Name', 'Designation', 'Department', 'Employee Status', 'Reason'],['name', 'designation', 'department', 'employee_status', 'employee_status_reason'], 'width: 100%; text-align: left;');
                $subject = 'Employee Status has been Updated.';
                $emailAddress = \App\Models\User::select('email')->whereIn('role', [3,4,5,7])->get();

                \Tritiyo\Task\Helpers\MailHelper::send($html, $subject, $emailAddress);
            }

            if ($userupdate == true) {
                return view('users.contact_info', ['user' => $user, 'id' => $id, 'message' => 'Successfully saved']);
            }
        } else {
            $user = $this->user->getById($id);
            return view('users.contact_info', ['user' => $user, 'id' => $id]);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function user_photos(Request $request, User $user, $id)
    {
        if (isset($request->user_photos)) {

            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg', //|max:2048,
                'signature' => 'required|image|mimes:jpeg,png,jpg,gif,svg' //|max:2048,
            ]);
            $avatar = time() . '.' . $request->avatar->extension();
            $signature = time() . '.' . $request->signature->extension();

            $avatar_data = $request->avatar->move(public_path('images/avatar'), $avatar);
            $signature_data = $request->signature->move(public_path('images/signature'), $avatar);

            $attributes = [
                'avatar' => 'public/images/avatar/' . $avatar,
                'signature' => 'public/images/signature/' . $signature
            ];
            //dd($attributes);
            $userupdate = $this->user->update($id, $attributes);
            $user = $this->user->getById($id);
            if ($userupdate == true) {
                return back()
                    ->with('success', 'You have successfully upload image.')
                    ->with('image', $avatar)
                    ->with('signature', $signature);
            }
        } else {
            $user = $this->user->getById($id);
            return view('users.user_photos', ['user' => $user, 'id' => $id]);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function user_permissions(Request $request, User $user, $id)
    {
        if (isset($request->user_permissions)) {
            dd($request->permission);

            $batch_data = [];
            foreach ($request->permission as $key => $data) {
                if ((!empty($data['checked']) && $data['checked'] == 'on') || (!empty($data['checked']) && $data['checked'] == 'off')) {
                    $this->permission->batchUpsert(
                        [
                            'user_id' => $data['user_id'],
                            'route_id' => $data['route_id']
                        ],
                        [
                            'user_id' => $data['user_id'],
                            'route_id' => $data['route_id'],
                            'checked' => $data['checked']
                        ]
                    );
                }
            }

            $user = $this->user->getById($id);
            if ($user == true) {
                return back()
                    ->with('message', 'Successfully saved')
                    ->with('user', $user)
                    ->with('id', $id);
            }
        } else {
            $user = $this->user->getById($id);
            return view('users.user_permissions', ['user' => $user, 'id' => $id]);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function financial_info(Request $request, User $user, $id)
    {
        if (isset($request->financial_info)) {
            //dd($request);
            //dd($request->all());
            $arrMobileBanking = [];
            if($request->mobile_bank_number) {
                foreach ($request->mobile_bank_number as $key => $number) {
                    //dump($mobileBank[$i]);
                    //dump($number);

                    $arrMobileBanking[] =
                        $request->mobile_bank_method[$key] . ' : ' . $number;
                }


                $packateMobileBanking = implode(' | ', $arrMobileBanking);
            } else {
                $packateMobileBanking = '';
            }
            $attributes = [
                'bank_information' => $request->bank_information,
                'mbanking_information' => $packateMobileBanking,
            ];

            $userupdate = $this->user->update($id, $attributes);
            $user = $this->user->getById($id);
            if ($userupdate == true) {
                return back()
                    ->with(['status' => 1, 'message' => 'Information updated.'])
                    ->with('user', $user)
                    ->with('id', $id);
            }
        } else {
            $user = $this->user->getById($id);
            return view('users.financial_info', ['user' => $user, 'id' => $id]);
        }
    }

    public function change_password(Request $request, $id)
    {
        $user = $this->user->getById($id);
        return view('auth.passwords.reset', ['user' => $user, 'id' => $id]);
    }

    public function update_password(Request $request, $id)
    {
        //dd($request);
        if(isset($id)) {

            $validator = Validator::make($request->all(),
                [
                    'password' => 'required',
                    'password_confirmation' => 'required'
                ]
            );

        // process the login
        if ($validator->fails()) {
            return redirect('users.update_password', auth()->user()->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            if($request->password == $request->password_confirmation) {
                $attributes = [
                    'password' => bcrypt($request->password)
                ];

                //$user = $this->user->getById();
                $userupdate = $this->user->update(auth()->user()->id, $attributes);
                if($userupdate == true) {
                    return redirect('dashboard')->with('message', 'Password has been changed successfully');
                }
            } else {
                return redirect('users.update_password', auth()->user()->id)
                ->withErrors('Password did not match with confirm password')
                ->withInput();
            }
        }
        }
    }

    public function reset_password($id)
    {
      	//dd($id);
        if (isset($id)) {
            $attributes = [
                'password' => bcrypt('mtsbd123')
            ];

            //$user = $this->user->getById();
            $userupdate = $this->user->update($id, $attributes);
            if ($userupdate == true) {
                return redirect('dashboard')->with('message', 'Password has been changed successfully');
            }
        }
    }


    public function download_excel_any(Request $request)
    {
        dd($request);
    }
  
  
  


}
