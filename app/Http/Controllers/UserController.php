<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;

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
        return view('users')->with('users_active', 'active');
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
            $users = DB::table('users')->select('users.name', 'users.email', 'users.posts', 'users.status')->where('users.type', 2);
            return Datatables::of($users)->addColumn('action', function ($user) {
                    return '<a href="#" class="btn edit ">EDIT</a>&nbsp;<a href="#" class="btn delete">DELETE</a>';
                })->make(true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to get rssfeed url datas by Id
     * 
     * @params $id
     * @return json response
     */
    public function getRssfeedById($id)
    {
        try {
            $update_rss_feeds = DB::table('rssfeed')
                    ->where('id', $id)->first();
            return \Response::json($update_rss_feeds);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
