@extends('student-portal.layout.master')
@section('content')
<div class="app-main__outer" style="width:100% !important; padding-left:0px">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-notebook  icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>ABP Terms & Conditions
                        <div class="page-title-subheading opacity-10">
                            <nav class="" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-home"></i>&nbsp;ABP
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{url('dashboard')}}">Dashboards</a>
                                    </li>
                                    <li class="active breadcrumb-item" aria-current="page">
                                        <a href="{{\Request::url()}}">
                                            {{isset($page_title) ? $page_title : ''}}
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>   
            </div>
        </div> 


        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card ">
                    <div class="card-body"> 
                        <div class=" col-md-12">
                            <h2>What personal data we collect and why we collect it</h2>
                            <h5>1. Comments</h5>                           
                            <p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor’s IP address and browser user agent string to help spam detection.<br>
   
                            An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p>
                            
                             
                            <h5>2. Media</h5>  <br>                          
                            <p> you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p>
                            
                             
                            <h5>3. Contact forms</h5> <br>                           
                            <p>The data you provide in your contact forms are kept secret and are being used for the relevant purpose and these data are not shared outside the organization.</p>
                            
                             
                            <h5>4. Cookies</h5>  <br>                          
                            <p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.<br>                          
                             
                            If you have an account and you log in to this site, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.<br>

                            When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select “Remember Me”, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.<br>
                            
                            If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day. </p>
                            
                             
                            <h5>5. Embedded content from other websites</h5>                            
                            <p> on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.<br>                            
                             
                            These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracing your interaction with the embedded content if you have an account and are logged in to that website.</p>
                            
                             
                            <h5>6. Analytics</h5> <br>                           
                            <p>We use google analytics for analysing web visitors behaviour and demography.</p>
                            
                             
                            <h2>How long we retain your data</h2><br>
                            
                            <p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.<br>
                            
                            For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p>
                            
                             
                            <h2>What rights you have over your data</h2><br>
                            <p> If you have an account on this site or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p>
                            
                        </div>
                    </div>
                </div>
            </div>
		</div>             
    </div>   
</div>
@endsection

