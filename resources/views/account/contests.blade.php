@extends('layouts.app')

@section('template')

<style>
    card {
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
    }
    card.img-card{
        padding:0;
        overflow: hidden;
        cursor: pointer;
    }

    card.img-card > img{
        width:100%;
        height:10rem;
        object-fit: cover;
    }
    card.img-card > div{
        text-align: center;
        padding: 1rem;
    }

    card.album-selected {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 40px!important;
        transform: scale(1.02);
    }
    card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }
    h5{
        margin-bottom:1rem;
    }
    .form-control:disabled, .form-control[disabled]{
        background-color: transparent;
    }
    .atsast-img-container{
        width: 100%;
        padding:2rem;
    }
    .atsast-img-container > img{
        width: 100%;
    }
    .atsast-upload{
        display: none;
    }

    #avatar{
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
    }

    contest{
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        overflow: hidden;
        z-index: 0;
    }


    contest > .atsast-img-container{
        overflow: hidden;
        height:15rem;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
    }

    contest:hover{
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    contest > .atsast-img-container-small{
        width:100%;
        height:15rem;
    }

    contest > .atsast-img-container-small > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    contest > .atsast-img-container::after{
        content: "";
        display: block;
        position: absolute;
        z-index: 1;
        top:-2.5rem;
        left:-2.5rem;
        bottom:-2.5rem;
        right:-1px;
        background:linear-gradient(to right,rgba(255,255,255,1) 10%,rgba(255,255,255,0) 100%);
    }

    contest > .atsast-content-container{
        /* display: flex;
        align-items: center; */
        height:100%;
        flex-shrink: 1;
        flex-grow: 1;
        padding:1rem;
        z-index: 1;
    }

    contest > .atsast-img-container > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    .atsast-empty{
        justify-content: center;
        align-items: center;
        height: 10rem;
    }

    badge{
        display: inline-block;
        padding: 0.25rem 0.75em;
        font-weight: 700;
        line-height: 1.5;
        text-align: center;
        vertical-align: baseline;
        border-radius: 0.125rem;
        background-color: #f5f5f5;
        margin: 1rem;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }
    .atsast-basic-info > span{
        padding-right:1rem;
    }
</style>

<div class="container mundb-standard-container">
    <h1 class="mb-3"><i class="MDI airballoon"></i> 我报名的活动</h1>
    <hr class="atsast-line mb-5">

        <div class="row @if(empty($register_contest_result->first()))atsast-empty @endif">
            @if(empty($register_contest_result->first()))
                <badge>这里将会展示所有我主动报名参加的活动</badge>
            @else
                @foreach($register_contest_result as $c)
                <div class="col-lg-6 col-md-12 atsast-courses">
                    <contest>
                        <div class="atsast-img-container-small">
                            <img src="{{$ATSAST_DOMAIN.$c->image}}">
                        </div>
                        <div class="atsast-content-container">
                            <h3 class="mundb-text-truncate-2">{{$c->name}}</h3>
                            <p class="mundb-text-truncate-1">{{$c->creator_name}} ·@if($c->type==1) 线上活动@else 线下活动@endif</p>
                            <p class="mundb-text-truncate-1 atsast-basic-info"> {!!$c->parse_status!!} <i class="MDI clock"></i> {{$c->parse_date}} </p>
                            <a href="{{$ATSAST_DOMAIN}}/contest/{{$c->contest_id}}/detail"><button class="btn btn-outline-info"><i class="MDI information-outline"></i> 活动信息</button></a>
                            <a href="{{$ATSAST_DOMAIN}}/contest/{{$c->contest_id}}/register"><button class="btn btn-outline-warning"><i class="MDI pencil"></i> 查看报名信息</button></a>
                        </div>
                    </contest>
                </div>
                @endforeach
            @endif
        </div>
    <h1 class="mb-3"><i class="MDI airballoon"></i> 我参加的活动</h1>
    <hr class="atsast-line mb-5">

        <div class="row @if(empty($attend_contest_result->first()))atsast-empty @endif">
            @if(empty($attend_contest_result->first()))
                <badge>这里将会展示所有我作为队员参加的活动</badge>
            @else
                @foreach($attend_contest_result as $c)
                <div class="col-lg-6 col-md-12 atsast-courses">
                    <contest>
                        <div class="atsast-img-container-small">
                            <img src="{{$ATSAST_DOMAIN.$c->image}}">
                        </div>
                        <div class="atsast-content-container">
                            <h3 class="mundb-text-truncate-2">{{$c->name}}</h3>
                            <p class="mundb-text-truncate-1">{{$c->creator_name}} ·@if($c->type==1) 线上活动@else 线下活动@endif</p>
                            <p class="mundb-text-truncate-1 atsast-basic-info"> {!!$c->parse_status!!} <i class="MDI clock"></i> {{$c->parse_date}} </p>
                            <a href="{{$ATSAST_DOMAIN}}/contest/{{$c->contest_id}}/detail"><button class="btn btn-outline-info"><i class="MDI information-outline"></i> 活动信息</button></a>
                            <a href="{{$ATSAST_DOMAIN}}/contest/{{$c->contest_id}}/register"><button class="btn btn-outline-warning"><i class="MDI pencil"></i> 查看报名信息</button></a>
                        </div>
                    </contest>
                </div>
                @endforeach
            @endif
        </div>
</div>
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modeal_title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="modeal_desc"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load",function() {
        ;
    }, false);
</script>

@endsection
