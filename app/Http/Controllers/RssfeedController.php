<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Rssfeed;

class RssfeedController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Function to get all rssfeed url datas
     * 
     * @return json response
     */
    public function getAllRssfeeds()
    {
        try {
            $rss_feeds = DB::table('rssfeed')->select('rssfeed.*', 'c.company_name')->leftJoin('company as c', 'c.id', '=', 'rssfeed.company_ID')->get();
            return $rss_feeds;
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
