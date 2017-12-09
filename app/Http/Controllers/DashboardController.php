<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
use App\Article;
use App\ArticleImage;

class DashboardController extends Controller
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
        return view('dashboard')->with('dashboard_active', 'active');;
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
