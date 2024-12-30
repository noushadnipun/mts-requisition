<?php

namespace App\Http\Controllers;

use App\Models\Routelist;
use App\Repositories\Routelist\RoutelistInterface;
use Illuminate\Http\Request;
use Validator;

class RoutelistController extends Controller
{
    /**
     * @var RoutelistInterface
     */
    private $routelist;

    /**
     * RoutelistController constructor.
     * @param RoutelistInterface $routelist
     */
    public function __construct(RoutelistInterface $routelist)
    {
        $this->routelist = $routelist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routelists = $this->routelist->getAll();
        return view('routelists.index', ['routelists' => $routelists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('routelists.create');
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
                'route_name' => 'required',
                'route_url' => 'required',
                'route_description' => 'required'
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
                'route_name' => $request->route_name,
                'route_url' => $request->route_url,
                'route_hash' => bcrypt($request->route_url),
                'to_role' => implode(',', $request->to_role),
                'route_grouping' => $request->route_grouping,
                'parent_menu_id' => $request->parent_route_id,
                'show_menu' => $request->show_menu,
                'skip_sub' => $request->skip_sub,
                'dashboard_menu' => $request->dashboard_menu,
                'font_awesome' => $request->font_awesome,
                'bulma_class_icon_bg' => $request->bulma_class_icon_bg,
                'route_description' => $request->route_description,
                'route_note' => $request->route_note
            ];

            try {
                $routelist = $this->routelist->create($attributes);
                return view('routelists.create')->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return view('routelists.create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Routelist $routelist
     * @return \Illuminate\Http\Response
     */
    public function show(Routelist $routelist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Routelist $routelist
     * @return \Illuminate\Http\Response
     */
    public function edit(Routelist $routelist)
    {
        return view('routelists.edit', ['routelist' => $routelist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Routelist $routelist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Routelist $routelist)
    {
        // store
        $attributes = [
            'route_name' => $request->route_name,
            'route_url' => $request->route_url,
            'route_hash' => bcrypt($request->route_url),
            'to_role' => implode(',', $request->to_role),
            'route_grouping' => $request->route_grouping,
            'parent_menu_id' => $request->parent_route_id,
            'show_menu' => $request->show_menu,
            'skip_sub' => $request->skip_sub,
            'dashboard_menu' => $request->dashboard_menu,
            'font_awesome' => $request->font_awesome,
            'bulma_class_icon_bg' => $request->bulma_class_icon_bg,
            'route_description' => $request->route_description,
            'route_note' => $request->route_note
        ];

        //dd($attributes);

        try {
            $routelist = $this->routelist->update($routelist->id, $attributes);
            return redirect()->route('routelists.index', ['status' => 1, 'message' => 'Successfully updated']);
        } catch (\Exception $e) {
            return view('routelists.edit', $routelist->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Routelist $routelist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Routelist $routelist)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {

        $default = [
            'search_key' => $request->key ?? 'users',
            'limit' => 10,
            'offset' => 0
        ];
        $routelists = $this->routelist->getDataByFilter($default, $totalrowcount = false);
        return view('routelists.index', ['routelists' => $routelists]);
    }
}
