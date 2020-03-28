<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contacts;
use App\Faq;
use App\Posts;
use Illuminate\Http\Request;
use App\Services;
use App\SiteInfo;
use App\SiteSettings;
use App\Subscribers;
use App\Tags;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller {

    public function __construct () {}

    public function front (Request $request, $page = 'home', $subPage=null, $backPage=null) {

        if (SiteSettings::in_maintenance() && !Auth::check()) {
            return redirect('/maintenance');
        }

        if (! file_exists ( resource_path('views/front_page/'.$page.".blade.php" ) ) ) {
            abort('404');
        }
    

        $data['page_name'] = $page;
        $page_ui = $page;
        $data['subPage'] = '';

        $data['page_title'] = ucwords (str_replace('-', ' ', $page));
        $data['faqs'] = Faq::all();

        $data['site_info'] = [];

        foreach (SiteInfo::all() as $key) {
            $data['site_info'][$key->name] = $key->content;
        }
        // dd($data['site_info']);

        if (($page=="home") || ($page=="about-us") || ($page=="contact-us") || ($page=="jobs")) {
            if (!is_null($subPage)) {
                abort('404');
            }
        }

        if ($page == 'home') {
            $data['description'] = $data['site_info']['site_short_description'];
            $data['keywords'] = 'Recruitment, Training, Recruitment Adversory, Searches';

            $data['services'] = Services::all();
            $data['latest_posts'] = Posts::fetchLatestThree();

            $s = "";
            foreach (Services::all() as $service) {
                $s.= ucwords ( strtolower ($service['title']). ' | ');
            }
            // Display in the Banner separated with | character
            $data['banner_services'] = rtrim($s, ' | ');
        }

        if ($page == "services") {
            if (!is_null($subPage)) {
                $page_ui = 'service_detail';
                $service = new Services();
                $data['subPage'] = ucwords (str_replace('-', ' ', $subPage));
                $serviceFound = $service->getByTitle($data['subPage']);
                            
                // checks if find service and
                // abort if not
                if (!is_null($serviceFound)) {
                    $data['description'] = $serviceFound->short_desc;
                    $data['keywords'] = $serviceFound->keywords;
                    $data['service'] = $serviceFound;
                    $data['other_services'] = $service->where('title', '!=', $serviceFound->title)->get();
                } else {
                    abort('404');
                }
                
                
            } else {
                $data['services'] = Services::all();
            }
        } elseif ($page == 'blog') {
            $data['categories'] = Category::all();
            if (!is_null($subPage)) {
                $page_ui = 'blog_detail';
                $post = new Posts();
                $data['subPage'] = ucwords (str_replace('-', ' ', $subPage));
                $postFound = $post->getByTitle($data['subPage']);
                // dd($postFound);
                if (!is_null($postFound)) {
                    $data['description'] = $postFound->short_desc;
                    $data['keywords'] = $postFound->keywords;
                    $data['author'] = $postFound->user->name;
                    $data['post'] = $postFound;
                    $data['tags'] = explode(';', $postFound->tags);
                    $data['relatedPosts'] = Posts::related($data['post']->id, $postFound->category);
                } else {
                    abort('404');
                }
            } else {
                $page_ui = $page;
                $data['posts'] = Posts::latest()->where('status', 'publish')->paginate(1);
                $data['tags'] = Tags::all();
                // dd($data['posts']->links);
            }
        }

        
        if (($page=="blog_detail") || ($page=="service_detail")) {
            
            abort('404');
            
        }

        if ($page == 'search') {
            $page_ui = $page;
            $data['posts'] = Posts::search( urldecode($request->query('title')), $request->query('cat'), $request->query('tag') );
            $data['categories'] = Category::all();
            $data['tags'] = Tags::all();
        }

        if ($page == 'legal') {

            if (($subPage == 'privacy') || ($subPage == 'terms-and-conditions')) {
                $headerTitleSplit = str_replace('-', ' ', $subPage);
                
                $data['header_title'] = add_html_snipet(strtoupper($headerTitleSplit), '<span class="text-generic-green">', '</span>', 'odd', '');

                $data['content'] = $data['site_info'][str_replace('-', '_', $subPage)];

            } else {
                abort('404');
            }
        }
        

        return view('front_page.'.$page_ui, $data);
        
    }

    public function maintenance () {
        $siteSettings = new SiteSettings();
        if (!$siteSettings->in_maintenance()) {
            redirect('/');
        }
        echo "on maintenance";
    }

    public function back ($page='dashboard', $action=null, $var=null) {
        
        $page_ui = $page;
        $data['page_title'] = ucwords($page);
        $data['user'] = Auth::user();
        $data['categories'] = \App\Category::all();

        if($page == 'dashboard') {
            $data['totalServices'] = number_format(Services::count());
            $data['totalContacts'] = number_format(Contacts::count());
            $data['totalSubscribers'] = number_format(Subscribers::count());
            $data['totalPosts'] = number_format(Posts::count());

            $data['latestContacts'] = Contacts::latest()->limit(10)->get();
            $data['recentPost'] = Posts::latest()->limit(10)->get();
        }

        if (($page == 'services') || ($page == 'posts')) {
            $class = 'App\\'.ucfirst($page);
            $data[$page] = $class::latest()->get();
        }

        if ($page == 'categories_tags') {
            $data['page_title'] = ucwords (str_replace('_', ' and ', $page));
            $data['categories'] = Category::all();
            $data['tags'] = Tags::all();
        }

        if ((($page == 'service') || ($page == 'post')) && (!is_null($action))) {
            $page_ui = $page.'_form';
            if ($page == "post") {
                $data['tags'] = Tags::all();
            }
            switch ($action) {
                case 'create':
                    $data['is_update'] = false;
                    $data['page_title'] = 'Create New '.ucwords($page);
                    if (!is_null($var)) {
                        abort('404');
                    }
                    break;
                case 'update':
                    if (is_numeric($var)) {
                        $data['page_title'] = 'Update '.$page;
                        // initializing the appropriate classname with its full path
                        $class = "App\\".ucfirst($page.'s');
                        // calling the find() method from the $class
                        $update_data = $class::find($var);
                        
                        if (!is_null($var) && ($update_data != null)) {
                            $data[$page] = $update_data;
                            $data['is_update'] = true;
                        } else {
                            abort('404');
                        }
                    } else {
                        abort('500');
                    }
                    break;
            }
        }

        if ($page == 'contacts_subscribers') {
            $data['page_title'] = ucwords(str_replace('_', ' and ', $page));
            $data['contacts'] = Contacts::latest()->get();
            $data['subscribers'] = Subscribers::latest()->get();
        }

        if ($page == 'resources') {
            $data['faqs'] = Faq::all();
            $data['site_info'] = SiteInfo::all();
            $data['maintenanceMode'] = SiteSettings::where('name', 'maintenance')->first()->value;
        }

        return view('backoffice.'.$page_ui, $data);
    }

    public function auth ($page) {
        if (! file_exists(resource_path('views/auth/'.$page.'.blade.php'))) {
            abort('400');
        }

        $data['page_title'] = ucwords(str_replace('_', ' ', $page));
        if ($page == 'login') {
            $this->middleware('guest')->except('logout');
        }
        return view('auth.'.$page, $data);
    }
}
