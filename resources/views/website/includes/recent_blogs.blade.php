<div class="blog blog content-area-12">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h2>Recent Blog Articles</h2>
        </div>
        <div class="row">
<div class="blog-container left relative feat-top-wrap">
<div class="feat-top2-left-wrap left relative">
<div class="feat-top2-left left relative">
<a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($blogs[0]->post_title),$blogs[0]->id])}}" rel="bookmark">
<div class="feat-top2-left-img left relative">
<img width="900" height="500" src="{{asset('img/blogs/'.$blogs[0]->image)}}" data-src="{{asset('img/blogs/'.$blogs[0]->image)}}" class="unlazy reg-img wp-post-image" alt="{{$blogs[0]->post_title}}" sizes="(max-width: 900px) 100vw, 900px">
<img width="450" height="270" src="{{asset('img/blogs/'.$blogs[0]->image)}}" data-src="{{asset('img/blogs/'.$blogs[0]->image)}}" class="unlazy mob-img wp-post-image" alt="{{$blogs[0]->post_title}}">
</div>
<div class="feat-top2-left-text">
<span class="feat-cat">{{$blogs[0]->category}}</span><h2 class="stand-title">{{$blogs[0]->post_title }}</h2></div>
<div class="feat-info-wrap"><div class="feat-info-views"><i class="fa fa-eye fa-2"></i> <span class="feat-info-text span-color">{{$blogs[0]->view_count}}</span>
</div>
</div>
</a>
</div>
</div>

<div class="feat-top2-right-wrap left relative">
<div class="feat-top2-right left relative">
<a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($blogs[1]->post_title),$blogs[1]->id])}}" rel="bookmark">
<div class="feat-top2-right-img left relative">
<img width="450" height="270" src="{{asset('img/blogs/'.$blogs[1]->image)}}" data-src="{{asset('img/blogs/'.$blogs[1]->image)}}" class="unlazy feat-top2-small wp-post-image" alt="{{$blogs[1]->post_title}}" sizes="(max-width: 450px) 100vw, 450px">
<img width="900" height="500" src="{{asset('img/blogs/'.$blogs[1]->image)}}" data-src="{{asset('img/blogs/'.$blogs[1]->image)}}" class="unlazy feat-top2-big wp-post-image" alt="{{$blogs[1]->post_title}}" sizes="(max-width: 900px) 100vw, 900px">
</div>
<div class="feat-top2-right-text">
<span class="feat-cat">{{$blogs[1]->category}}</span><h2>{{$blogs[1]->post_title}}</h2></div>
<div class="feat-info-wrap"><div class="feat-info-views"><i class="fa fa-eye fa-2"></i> <span class="feat-info-text span-color">{{$blogs[1]->view_count}}</span>
</div>
</div>
</a>
</div>


<div class="feat-top2-right left relative">
<a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($blogs[2]->post_title),$blogs[2]->id])}}" rel="bookmark">
<div class="feat-top2-right-img left relative"><img width="450" height="225" src="{{asset('img/blogs/'.$blogs[2]->image)}}" data-src="{{asset('img/blogs/'.$blogs[2]->image)}}" class="unlazy feat-top2-small wp-post-image" alt="{{$blogs[2]->post_title}}" sizes="(max-width: 450px) 100vw, 450px">
<img width="830" height="415" src="{{asset('img/blogs/'.$blogs[2]->image)}}" data-src="{{asset('img/blogs/'.$blogs[2]->image)}}" class="unlazy feat-top2-big wp-post-image" alt="{{$blogs[2]->post_title}}" sizes="(max-width: 830px) 100vw, 830px">
</div>
<div class="feat-top2-right-text">
<span class="feat-cat">{{$blogs[2]->category}}</span><h2>{{$blogs[2]->post_title}}</h2></div>
<div class="feat-info-wrap"><div class="feat-info-views"><i class="fa fa-eye fa-2"></i> <span class="feat-info-text span-color">{{$blogs[2]->view_count}}</span>
</div>
</div>
</a>
</div>

<div class="feat-top2-right left relative">
<a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($blogs[3]->post_title),$blogs[3]->id])}}" rel="bookmark">
<div class="feat-top2-right-img left relative">
<img width="450" height="225" src="{{asset('img/blogs/'.$blogs[3]->image)}}" data-src="{{asset('img/blogs/'.$blogs[3]->image)}}" class="unlazy feat-top2-small wp-post-image" alt="{{$blogs[3]->post_title}}" sizes="(max-width: 450px) 100vw, 450px">
<img width="830" height="415" src="{{asset('img/blogs/'.$blogs[3]->image)}}" data-src="{{asset('img/blogs/'.$blogs[3]->image)}}" class="unlazy feat-top2-big wp-post-image" alt="{{$blogs[3]->post_title}}" sizes="(max-width: 830px) 100vw, 830px">
</div>
<div class="feat-top2-right-text"><span class="feat-cat">{{$blogs[3]->category}}</span><h2>{{$blogs[3]->post_title}}</h2></div>
<div class="feat-info-wrap"><div class="feat-info-views"><i class="fa fa-eye fa-2"></i> <span class="feat-info-text span-color">{{$blogs[3]->view_count}}</span>
</div>
</div>
</a>
</div>
</div>
</div>

<div class="left relative row-widget-wrap feat-top-wrap">
<ul class="row-widget-list featured-news" id="popular-posts">
@for($i = 4; $i < count ($blogs); $i++)
<li><a href="{{route('blogs.show',[\Illuminate\Support\Str::slug($blogs[$i]->post_title),$blogs[$i]->id])}}" rel="bookmark">
<div class="row-widget-img left relative">
<img width="300" height="150" src="{{asset('img/blogs/'.$blogs[$i]->image)}}" data-src="{{asset('img/blogs/'.$blogs[$i]->image)}}" class="reg-img wp-post-image" alt="{{$blogs[$i]->post_title}}" sizes="(max-width: 300px) 100vw, 300px">
<img width="80" height="40" src="{{asset('img/blogs/'.$blogs[$i]->image)}}" data-src="{{asset('img/blogs/'.$blogs[$i]->image)}}" class="mob-img wp-post-image" alt="{{$blogs[$i]->post_title}}" sizes="(max-width: 80px) 100vw, 80px">
<div class="feat-info-wrap">
<div class="feat-info-views"><i class="fa fa-eye fa-2"></i> <span class="feat-info-text span-color">{{$blogs[$i]->view_count}}</span>
</div>
</div>
</div>
<div class="row-widget-text left relative"><h4><span class="side-list-cat">{{$blogs[$i]->category}}</span></h4><h5 class="recent-title">{{$blogs[$i]->post_title}}</h5>
</div>
</a> 
</li>
@endfor
</ul>
</div>                
</div>
</div> </div>
