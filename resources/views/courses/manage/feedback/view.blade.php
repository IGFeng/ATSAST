@extends('layouts.app')

@section('template')

<style>
    nav.navbar,#nav-container {
        margin-bottom: 0 !important;
    }

    .mundb-standard-container {
        margin-top: 5rem;
    }

    .atsast-course-creator {
        height: 5rem;
    }

    .atsast-focus-img {
        width: 100%;
        height: 15rem;
        object-fit: cover;
        filter: brightness(0.75);
        -webkit-filter: brightness(0.75);
        user-select: none;
        pointer-events: none;
    }

    .atsast-course-header {
        position: relative;
    }

    .atsast-course-header .container {
        position: relative;
    }

    .atsast-course-avatar {
        position: absolute;
        bottom: -2.5rem;
        width: 10rem;
        height: 10rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 6rem;
        /* background: #009988; */
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
    }

    .atsast-course-header h1 {
        font-weight: 100;
        position: absolute;
        bottom: 0;
        left: calc(11rem + 15px);
        line-height: 1.5;
        color: #fff;
    }

    .atsast-course-header p {
        font-weight: 100;
        position: absolute;
        bottom: 3.75rem;
        left: calc(11rem + 15px);
        line-height: 1.2;
        color: #fff;
    }
    .atsast-course-header button.btn.btn-lg {
        padding:.5rem 1.5rem;
        font-weight: 100;
        position: absolute;
        bottom: 0.675rem;
        right: 15px;
        color: #fff;
    }

    instructor {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0.25rem;
        margin-bottom: 1rem;
    }

    instructor>img {
        width: 5rem;
        height: 5rem;
        border-radius: 2000px;
        flex-shrink: 0;
        flex-grow: 0;
    }

    instructor>div {
        padding-left: 1rem;
        flex-shrink: 1;
        flex-grow: 1;
    }

    instructor p {
        margin: 0;
    }

    hr.atsast-line {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .atsast-title {
        text-align: center;
        padding-bottom: 1rem;
    }
    .atsast-title h1,
    .atsast-title p {
        font-weight: 100;
    }

    .atsast-title > button{
        margin:1rem 0;
    }

    .atsast-basic-info {
        border: 1px solid #ddd;
        width: 100%;
        border-collapse: collapse;
        background-color: transparent;
    }

    instructor small,
    th{
        font-weight: 100;
        color: #8a6219;
    }

    td{
        font-weight: 100;
    }

    tbody i.MDI{
        transform: scale(1.5);
        display: inline-block;
        padding-right: 0.5rem;
    }

    .atsast-tooltip{
        text-align: center;
    }

    .btn-raised[disabled]{
        pointer-events: none;
    }

    syllabus > h3{
        padding:1rem 0;
        font-weight: 100;
    }

    syllabus > info {
        padding-right:1rem;
        color: #6e767f;
        font-weight: 900;
    }

    syllabus action {
        /* padding-right:1rem; */
        color: #6e767f;
        font-weight: 900;
        line-height: 1;
    }

    syllabus action > i {
        color: #3f51b5;
    }

    syllabus i{
        font-size: 2rem;
        vertical-align: middle;
        color: #8a6219;
        font-weight: 100;
    }

    .atsast-action{
        margin-top:1rem;
        text-align: right;
    }

    .atsast-action small{
        padding-right:1rem;
    }

    [id^="code_submit_section"]{
        transition: .2s ease-out .0s;
        opacity: 0;
    }

    [id^="markdown_container"]{
        transition: .2s ease-out .0s;
        opacity: 0;
    }

    file-info{
        display: flex;
        align-items: center;
        max-width: 100%;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    file-info a:hover{
        text-decoration: none;
    }

    file-info:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    file-info > div:first-of-type{
        display: flex;
        align-items: center;
        padding-right:1rem;
        width:5rem;
        height:5rem;
        flex-shrink: 0;
        flex-grow: 0;
    }

    file-info img{
        display: block;
        width:100%;
    }

    file-info > div:last-of-type{
        flex-shrink: 1;
        flex-grow: 1;
    }

    file-info p{
        margin:0;
    }

    @media (max-width: 991px) {
        .atsast-course-header>.container {
            max-width: 100%;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .atsast-course-avatar {
            position: absolute;
            left: calc(50vw - 5rem);
        }
    }
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
        overflow: hidden;
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
    .emoticon-happy,.emoticon-sad{
        display: inline-block;
        transform: scale(2);
        padding-right: 0.5rem;
    }
    .atsast-title-h5{
        color: #7a8e97;
        padding:0.5rem 1rem;
    }
</style>
<div class="atsast-course-header">
    <img src="{{$ATSAST_DOMAIN}}/static/img/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar {{$course->course_color}}">
            @if(strlen($course->course_logo) <= 3)
                <i>{{$course->course_logo}}</i>
            @else
                <i class="{{$course->course_logo}}"></i>
            @endif
        </div>
        <p class="d-none d-lg-block">{{$course->organization->name}}·{{$course->course_type == 1 ? '线上' : '线下'}}课程</p>
        <h1 class="d-none d-lg-block">{{$course->course_name}}</h1>
    </div>
</div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$course->course_name}}</h1>
        <p>{{$course->organization->name}}·{{$course->course_type == 1 ? '线上' : '线下'}}课程</p>
    </div>

    <card class="mb-3">
        <h5><i class="MDI file-document"></i> 课时详情</h5>
        <div>
            <h2>{{$syllabus->title}}</h2>
            <p>{{$syllabus->desc}}</p>
            <p>
                <span class="d-block d-lg-inline-block"><i class="MDI clock"></i> {{ $syllabus->time }}</span>
                <span class="d-block d-lg-inline-block"><i class="MDI near-me"></i> {{ $syllabus->location }}</span>
            </p>
        </div>
        <div class="text-right">
            <button class="btn btn-default" onclick="location.href='{{$ATSAST_DOMAIN.route('course.detail',['cid' => $course->cid],false)}}">查看课时详情</button>
            <button type="submit" class="btn btn-outline-primary" onclick="location.href='{{$ATSAST_DOMAIN.route('course.manage',['cid' => $course->cid],false)}}'">返回管理中心</button>
        </div>
    </card>
    <h5 class="atsast-title-h5">课程反馈</h5>
    <div id="accordion" class="mb-5">
        @foreach($feedbacks as $feedback)
        <card class="p-0">
            <div class="card-header" id="heading{{$feedback->uid}}">
                <h5 class="mb-0">
                    <button class="btn btn-block wemd-transparent text-right" data-toggle="collapse" data-target="#collapse{{$feedback->uid}}" aria-expanded="false" aria-controls="collapse{{$feedback->uid}}">
                        <i class="MDI {{$feedback->rank ? 'emoticon-happy wemd-green-text' : 'emoticon-sad wemd-red-text'}}"></i> {{$feedback->user->real_name}} {{$feedback->user->SID}}
                    </button>
                </h5>
            </div>

            <div id="collapse{{$feedback->uid}}" class="collapse" aria-labelledby="heading{{$feedback->uid}}" data-parent="#accordion">
                <div class="card-body">
                        <p><strong>满意程度：</strong>{{$feedback->rank ? '满意' : '不满意'}}</p>
                        <p><strong>反馈时间：</strong>{{$feedback->feedback_time}}</p>
                        <p><strong>反馈详情：</strong>{{$feedback->desc}}</p>
                </div>
            </div>
        </card>
        @endforeach
    </div>
</div>

@endsection
