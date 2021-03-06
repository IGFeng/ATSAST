@extends('layouts.app')

@section('template')

<link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/fonts/Raleway/raleway.css">
<style>
    body{
    /*background: url(<{$imgurl}>) 0 / cover fixed;*/
    }

    .carousel {
        border-radius:0;
        overflow:hidden;
        /* box-shadow: 0 0 2px 0 rgba(0,0,0,.14), 0 2px 2px 0 rgba(0,0,0,.12), 0 1px 3px 0 rgba(0,0,0,.2); */
    }

    .carousel-caption{
        padding: 0;
        bottom: 0;
        top: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    nav.navbar{
        margin-bottom: 30px;
        top: 0;
        position: absolute;
        right: 0;
        left: 0;
        background: rgba(66, 66, 66, 0.65)!important;
        box-shadow: none;
    }

    @media (min-width: 992px){
        nav.navbar{
            background: transparent!important;
        }
    }

    .container-fluid{
        padding:0;
    }

    .carousel-item > img{
        height:100vh;
        object-fit: cover;
    }

    footer{
        display:none;
    }

    .carousel-fade .carousel-item {
        opacity: 0;
        transition-duration: .6s;
        transition-property: opacity
    }

    .carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right,.carousel-fade .carousel-item.active {
        opacity: 1
    }

    .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right {
        opacity: 0
    }

    .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-prev,.carousel-fade .carousel-item-next,.carousel-fade .carousel-item-prev,.carousel-fade .carousel-item.active {
        -webkit-transform: translateX(0);
        transform: translateX(0)
    }

    @supports ((-webkit-transform-style: preserve-3d) or (transform-style:preserve-3d)) {
        .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-prev,.carousel-fade .carousel-item-next,.carousel-fade .carousel-item-prev,.carousel-fade .carousel-item.active {
            -webkit-transform:translate3d(0,0,0);
            transform: translate3d(0,0,0)
        }
    }

    #nav-container {
        margin-bottom: 0px !important;
    }
</style>

<div class="container-fluid">

    <div id="mixed" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#mixed" data-slide-to="0" class="active"></li>
            <li data-target="#mixed" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{"https://cn.bing.com/".bing_img_url()}}" alt="First slide">
                <div class="carousel-caption">
                    <div>
                        <h5 class="card-title mundb-text-truncate-2">@SAST正式启用啦</h5>
                        <p class="card-text d-none d-md-block mundb-text-truncate-2">@SAST是校科协辅助教学平台，由后端组开发。提供多样化的辅助教学功能。</p>
                        <a href="{{$ATSAST_DOMAIN}}/course/1/detail"><button class="btn btn-outline-light">相关课程</button></a>
                    </div>
                </div>
            </div>
            @if(!empty($carousels))
                @foreach($carousels as $carousel)
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ substr($carousel->image,0,4) == 'http' ? $carousel->image : $ATSAST_DOMAIN.$carousel->image}}" alt="First slide">
                        <div class="carousel-caption">
                            <div>
                                <h5 class="card-title mundb-text-truncate-2">{{$carousel->title}}</h5>
                                <p class="card-text d-none d-md-block mundb-text-truncate-2">{{$carousel->content}}</p>
                                <a href="{{ substr($carousel->url,0,4) == 'http' ? $carousel->url : $ATSAST_DOMAIN.$carousel->url}}"><button class="btn btn-outline-light">{{$carousel->button}}</button></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <a class="carousel-control-prev" href="#mixed" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">前</span>
        </a>
        <a class="carousel-control-next" href="#mixed" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">后</span>
        </a>
    </div>

</div>

<script>
    window.addEventListener("load",function() {

    }, false);
</script>
@endsection
