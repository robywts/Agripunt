<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\User;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Displays front end user view
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.list')->with('users_active', 'active');
    }

    /**
     * Function to get all users
     * 
     * @return json response
     */
    public function getAllUsers()
    {
        try {
            $requestData = $_REQUEST;
//            if (isset($requestData['columns'][2]['search']['value'])) {
//                        $status = 1;
//                        $query->where('users.status', '=', $status);
//                    }
            $users = DB::table('users')->select('users.id', 'users.name', 'users.email', 'users.posts', 'users.status')->where('users.type', 2);
            return Datatables::of($users)->addColumn('action', function ($user) {
                    return '<form action="' . route('users.delete', $user->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="user/edit/' . $user->id . '" class="btn edit ">EDIT</a>&nbsp; <button onclick="return confirm(\'Are you sure want to delete this User?\')" type="submit" class="btn delete">
                    Delete</button>
                    </form>';
                })->make(true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function editUsers($id)
    {
        try {
            $user = DB::table('users')->select('users.id', 'users.name', 'users.email', 'users.status')
                    ->where('id', $id)->first();
            return view('users.edit')->with('user', $user)->with('users_active', 'active');
//           / return \Response::json($user);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateUser(Request $request, $id)
    {
        request()->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'status' => 'required',
            ], [

            'name.required' => trans('custom_validation.user_name_required'),
            'email.required' => trans('custom_validation.user_email_required'),
            'email.email' => trans('custom_validation.user_email_valid'),
            'email.unique' => trans('custom_validation.user_email_unique'),
            'status.required' => trans('custom_validation.user_status_required'),
        ]);
        User::find($id)->update($request->all());
        return redirect()->route('users.edit', ['id' => $id])
                ->with('success', trans('custom_validation.user_update_success'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function createUser()
    {
        // load the create form (app/views/nerds/create.blade.php)
        return view('users.add')->with('users_active', 'active');
        ;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        request()->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            ], [

            'name.required' => trans('custom_validation.user_name_required'),
            'email.required' => trans('custom_validation.user_email_required'),
            'email.email' => trans('custom_validation.user_email_valid'),
            'email.unique' => trans('custom_validation.user_email_unique'),
        ]);
        $input = $request->all();
        $input['password'] = bcrypt(config('settings.user_pwd'));
        User::create($input);
        return redirect()->route('users.add')
                ->with('success', trans('custom_validation.user_create_success'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUser($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')
                ->with('success', trans('custom_validation.user_delete_success'));
    }

    /**
     * Function to edit rssfeed url datas by Id
     * 
     * @params $request
     * @return json response
     */
    public function updateRssfeed(Request $request, $id)
    {
        try {
            $rssData = $request->except('_token');

            $messsages = array(
                'company_ID.required' => trans('custom_validation.company_ID_required'),
                'rss_description.required' => trans('custom_validation.rss_description_required'),
                'rss_url.required' => trans('custom_validation.rss_url_required'),
                'rss_url.url' => trans('custom_validation.rss_url_valid'),
                'rss_publishdirect.required' => trans('custom_validation.rss_publishdirect_required'),
            );

            $rules = array(
                'company_ID' => 'required',
                'rss_description' => 'required',
                'rss_url' => 'required|url',
                'rss_publishdirect' => 'required'
            );

            $validator = Validator::make($rssData, $rules, $messsages);
            if ($validator->fails()) {
                print_r($validator->messages());
                exit;
            } else {
                $rssfeed = Rssfeed::find($id);
                $rssfeed->company_ID = $rssData['company_ID'];
                $rssfeed->rss_description = $rssData['rss_description'];
                $rssfeed->rss_url = $rssData['rss_url'];
                $rssfeed->rss_publishdirect = $rssData['rss_publishdirect'];
                $rssfeed->rss_active = $rssData['rss_publishdirect'];
                $rssfeed->save();
                if ($rssfeed)
                    return 0;
                else
                    return 1;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to add rssfeed url data
     * 
     * @params $request
     * @return json response
     */
    public function addRssfeed(Request $request)
    {
        try {
            $rssData = $request->except('_token');
            $messsages = array(
                'company_ID.required' => trans('custom_validation.company_ID_required'),
                'rss_description.required' => trans('custom_validation.rss_description_required'),
                'rss_url.required' => trans('custom_validation.rss_url_required'),
                'rss_url.url' => trans('custom_validation.rss_url_valid'),
                'rss_publishdirect.required' => trans('custom_validation.rss_publishdirect_required'),
            );

            $rules = array(
                'company_ID' => 'required',
                'rss_description' => 'required',
                'rss_url' => 'required|url',
                'rss_publishdirect' => 'required'
            );

            $validator = Validator::make($rssData, $rules, $messsages);
            if ($validator->fails()) {
                print_r($validator->messages());
                exit;
            } else {
                $rssfeed = Rssfeed::firstOrCreate($rssData);
                if ($rssfeed)
                    return 0;
                else
                    return 1;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
