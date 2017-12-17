<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
use App\Article;
use App\ArticleImage;
use DataTables;

class ArticleController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Function to get all articles
     * 
     * @return json response
     */
    public function getAllArticles($user_id)
    {
        try {
//            $articles = DB::table('article')->leftJoin('article_subject', 'article_subject.article_ID', '=', 'article.id')->leftJoin('subject', 'article_subject.subject_ID', '=', 'subject.id')
//                    ->leftJoin('article_company', 'article_company.article_ID', '=', 'article.id')->leftJoin('company', 'article_company.company_ID', '=', 'company.id')->leftJoin('article_file', 'article_file.article_ID', '=', 'article.id')->leftJoin('file', 'article_file.file_ID', '=', 'file.id')->select('article.id', 'article.article_title', 'article.article_comment', 'company.company_name', 'subject.subject_name', 'file.file_name as topic')->where('article.user_id', $user_id)->get();

             $articles = DB::table('article')->leftJoin('article_subject', 'article_subject.article_ID', '=', 'article.id')->leftJoin('subject', 'article_subject.subject_ID', '=', 'subject.id')
                    ->leftJoin('article_company', 'article_company.article_ID', '=', 'article.id')->leftJoin('company', 'article_company.company_ID', '=', 'company.id')->leftJoin('article_file', 'article_file.article_ID', '=', 'article.id')->leftJoin('file', 'article_file.file_ID', '=', 'file.id')->select('article.id', 'article.article_title', 'article.article_comment', DB::raw("(GROUP_CONCAT(DISTINCT company.company_name SEPARATOR ', ')) as `company_name`"), DB::raw("(GROUP_CONCAT(DISTINCT subject.subject_name SEPARATOR ', ')) as `subject_name`"), DB::raw("(GROUP_CONCAT(DISTINCT file.file_name SEPARATOR ', ')) as `topic`"))->groupBy('article.id')->where('article.user_id', $user_id)->get();

            
            return Datatables::of($articles)->addColumn('action', function ($article) {
                    return '<form action="' . route('users.delete', $article->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="user/edit/' . $article->id . '" class="btn edit ">EDIT</a>&nbsp; <button onclick="return confirm(\'Are you sure want to delete this User?\')" type="submit" class="btn delete">
                    Delete</button>
                    </form>';
                })->make(true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function test()
    {
        try {
            $feed_urls = DB::table('rssfeed')->select('id', 'rss_url')->get();
            foreach ($feed_urls as $feed_url) {
                $content = file_get_contents($feed_url->rss_url);
                if ($content) {
                    $x = new SimpleXmlElement($content);

                    echo "<ul>";

                    foreach ($x->channel->item as $entry) {
                        $rss_feed = [];
                        $rss_feed_img = [];
                        $rss_feed['rssfeed_ID'] = $feed_url->id;
                        $rss_feed['article_title'] = (string) $entry->title;
                        $rss_feed['article_content'] = (string) $entry->description;
                        $rss_feed['article_pubdate'] = date('Y-m-d', strtotime($entry->pubDate));
                        $arts = Article::firstOrCreate($rss_feed);
                        $rss_feed_img['article_ID'] = $arts->id;
                        $rss_feed_img['image_url'] = $entry->enclosure[0]['url'];
                        $arts_img = ArticleImage::firstOrCreate($rss_feed_img);
//                        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
                    }
                    echo "</ul>";
                }
            }
        } catch (\Exception $e) {
            echo "fdsfdsf";
            return $e->getMessage();
        }
    }
}
