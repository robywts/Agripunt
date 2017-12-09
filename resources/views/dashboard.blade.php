
@extends('layouts.custom_app')

@section('content')
                <!-- Example DataTables Card-->
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">569</div> 
                                        <div class="dash-cat">Users</div>                

                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="manage_users.html" id="toggleNavPosition">View Users</a>
                                    <a class="btn btn-primary" href="invite_users.html" id="toggleNavPosition">Invite User</a>              </div>



                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">1024</div> 
                                        <div class="dash-cat">Posts</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="manage_posts.html" id="toggleNavPosition">View  Posts</a>
                                    <a class="btn btn-primary" href="add_new_post.html" id="toggleNavPosition">Add Post</a>
                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">153</div> 
                                        <div class="dash-cat">News Categories</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="news_categories.html" id="toggleNavPosition">View Categories</a>
                                    <a class="btn btn-primary" href="add_new_category.html" id="toggleNavPosition">Add Category</a>
                                </div>



                            </div>
                        </div>


                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">85</div> 
                                        <div class="dash-cat">News Topics</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="news_topics.html" id="toggleNavPosition">View Topics</a>
                                    <a class="btn btn-primary" href="add_new_topic.html" id="toggleNavPosition">Add  Topic</a>
                                </div>



                            </div>
                        </div>


                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">3</div> 
                                        <div class="dash-cat">RSS Feeds</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="rss_feeds.html" id="toggleNavPosition">View Feeds</a>

                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4  col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">3015</div> 
                                        <div class="dash-cat">Newsletter Subscribers</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="newsletter_subscribers.html" id="toggleNavPosition">View Subscribers</a>

                                </div>



                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card o-hidden h-100 red">
                                <div class="card-body">

                                    <div class="mr-5"><div class="count">89</div> 
                                        <div class="dash-cat">Companies</div>


                                    </div>
                                </div>

                                <div class="dashboard-card-btn">

                                    <a class="btn btn-primary" href="companies.html" id="toggleNavPosition">View Companies</a>
                                    <a class="btn btn-primary" href="add_new_company.html" id="toggleNavPosition">Add Company</a>
                                </div>



                            </div>
                        </div>

                    </div>


                </div>
                @endsection
          
