@extends('layouts.app')

@section('template')

<style>
    nav.navbar {
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

    img{
        max-width: 100%;
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
</style>
<link rel="stylesheet" href="{{$ATSAST_CDN}}/css/github.min.css">
<link rel="stylesheet" data-name="vs/editor/editor.main" href="{{$ATSAST_CDN}}/vscode/vs/editor/editor.main.css">
<link rel="stylesheet" href="{{$ATSAST_CDN}}/css/simplemde.min.css">
<div class="atsast-course-header">
    <img src="https://static.1cf.co/img/atsast/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar {{$result['course_color']}}">
            @if(strlen($result['course_logo']) <= 3)
                <i>{{$result['course_logo']}}</i>
            @else
                <i class="{{$result['course_logo']}}"></i>
            @endif
        </div>
        <p class="d-none d-lg-block">{{$result['creator_name']}}·{{if $result['course_type']==1}}线上{{else}}线下{{/if}}课程</p>
        <h1 class="d-none d-lg-block">{{$result['course_name']}}</h1>
    </div>
</div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$result['course_name']}}</h1>
        <p>{{$result['creator_name']}}·{{if $result['course_type']==1}}线上{{else}}线下{{/if}}课程</p>
    </div>
    <section class="mb-5">
        <h2>{{$syllabus_info['title']}} - 作业详情</h2>
    </section>
    {{foreach $homework as $h}}
    <section class="mb-5">
        <div class="mb-1" id="markdown_container_{{$h['hid']}}">

        </div>
        {{ if $h['type']==0}}
        <!-- Silence is Golden -->
        {{ elseif $h['type']==1}}
        <div class="mb-5" id="code_submit_section_{{$h['hid']}}">
            <div id="vscode_{{$h['hid']}}" style="width:100%;height:30rem;border:1px solid grey"></div>
            <div class="atsast-action"><p>截止日期 {{$h['due_submit']}}</p></div>
            <div class="atsast-action">
                <small id="info_submit_{{$h['hid']}}" class="text-secondary">{{ if @$homework_submit[$h['hid']] }}已于 {{ $homework_submit[$h['hid']]['submit_time'] }} 提交{{/if}}</small>
                <button onclick="submit_code(this)" data-hid="{{$h['hid']}}" id="btn_submit_{{$h['hid']}}" class="btn btn-outline-primary">{{ if @$homework_submit[$h['hid']] }}再次{{/if}}提交</button>
            </div>
        </div>
        {{ elseif $h['type']==2 }}
        <div class="mb-5" id="markdwon_submit_section_{{$h['hid']}}">
            <textarea id="markdwon_editor_{{$h['hid']}}" style="width:100%;height:30rem;border:1px solid grey"></textarea>
            <div class="atsast-action"><p>截止日期 {{$h['due_submit']}}</p></div>
            <div class="atsast-action">
                <small id="info_submit_{{$h['hid']}}" class="text-secondary">{{ if @$homework_submit[$h['hid']] }}已于 {{ $homework_submit[$h['hid']]['submit_time'] }} 提交{{/if}}</small>
                <button onclick="submit_markdown(this)" data-hid="{{$h['hid']}}" id="btn_submit_{{$h['hid']}}" class="btn btn-outline-primary">{{ if @$homework_submit[$h['hid']] }}再次{{/if}}提交</button>
            </div>
        </div>
        {{ elseif $h['type']==3 }}
        <div class="mb-5" id="file_submit_section_{{$h['hid']}}">
            <div id="file_uploader_{{$h['hid']}}" style="width:100%;">
                <form id="file_uploade_form_{{$h['hid']}}" class="d-none">
                    <input type="file" name="file" class="custom-file-input" id="file_uploade_input_{{$h['hid']}}" data-hid="{{$h['hid']}}" onchange='SubmitFile(this)'>
                </form>
                <file-info>
                    <div>
                        <img id="file_uploade_extension_{{$h['hid']}}" src="{{$ATSAST_CDN}}/img/files/unknown.svg" onerror="this.src=unknown_svg;">
                    </div>
                    <div>
                        <h5 class="mundb-text-truncate-1" id="file_uploade_name_{{$h['hid']}}">尚未提交文件</h5>
                        <p><a class="text-info d-none" id="file_uploade_link_{{$h['hid']}}" href="#">下载</a></p>
                    </div>
                </file-info>
            </div>
            <div class="atsast-action"><p>截止日期 {{$h['due_submit']}}</p></div>
            <div class="atsast-action">
                <small id="info_submit_{{$h['hid']}}" class="text-secondary">{{ if @$homework_submit[$h['hid']] }}已于 {{ $homework_submit[$h['hid']]['submit_time'] }} 提交{{/if}}</small>
                <button onclick="$('#file_uploade_input_{{$h['hid']}}').click()" data-hid="{{$h['hid']}}" id="btn_submit_{{$h['hid']}}" class="btn btn-outline-info">{{ if @$homework_submit[$h['hid']] }}再次{{/if}}选择文件并提交</button>
            </div>
        </div>
        {{/if}}
    </section>
    {{/foreach}}
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
    <script src="{{$ATSAST_CDN}}/js/purify.min.js"></script>
    <script src="{{$ATSAST_CDN}}/js/simplemde.min.js"></script>
    <script>
        var unknown_svg='data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56 56" style="enable-background:new 0 0 56 56" xml:space="preserve"><g><path style="fill:%23e9e9e0" d="M36.985,0H7.963C7.155,0,6.5,0.655,6.5,1.926V55c0,0.345,0.655,1,1.463,1h40.074 c0.808,0,1.463-0.655,1.463-1V12.978c0-0.696-0.093-0.92-0.257-1.085L37.607,0.257C37.442,0.093,37.218,0,36.985,0z"/><polygon style="fill:%23d9d7ca" points="37.5,0.151 37.5,12 49.349,12"/><path style="fill:%23c8bdb8" d="M48.037,56H7.963C7.155,56,6.5,55.345,6.5,54.537V39h43v15.537C49.5,55.345,48.845,56,48.037,56z"/><circle style="fill:%23fff" cx="18.5" cy="47" r="3"/><circle style="fill:%23fff" cx="28.5" cy="47" r="3"/><circle style="fill:%23fff" cx="38.5" cy="47" r="3"/></g></svg>';
        var require = { paths: { 'vs': '{{$ATSAST_CDN}}/vscode/vs' } };
        var editor=Array,markdownEditor=Array,jsCnt=0,jsCnt2=0;
        function loadJsAsync(url){
            var body = document.getElementsByTagName('body')[0];
            var jsNode = document.createElement('script');

            jsNode.setAttribute('type', 'text/javascript');
            jsNode.setAttribute('src', url);
            body.appendChild(jsNode);
            //console.log(jsNode);
            jsNode.onload = function() {
                jsCnt++;
                //console.log(jsCnt);
                if(jsCnt==1){
                    console.log(111);
                    require.config({ paths: { 'vs': '{{$ATSAST_CDN}}/vscode/vs' }});

                    // Before loading vs/editor/editor.main, define a global MonacoEnvironment that overwrites
                    // the default worker url location (used when creating WebWorkers). The problem here is that
                    // HTML5 does not allow cross-domain web workers, so we need to proxy the instantiation of
                    // a web worker through a same-domain script

                    window.MonacoEnvironment = {
                    getWorkerUrl: function(workerId, label) {
                        return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                        self.MonacoEnvironment = {
                            baseUrl: '{{$ATSAST_CDN}}/vscode/'
                        };
                        importScripts('{{$ATSAST_CDN}}/vscode/vs/base/worker/workerMain.js');`
                        )}`;
                    }
                    };

                    require(["vs/editor/editor.main"], function () {
                        {{foreach $homework as $h}}
                        {{ if $h['type']==1}}
                        editor[{{$h["hid"]}}] = monaco.editor.create(document.getElementById('vscode_{{$h["hid"]}}'), {
                            value: "{{ if isset($homework_submit[$h['hid']]['submit_content_slashed'])}}{{$homework_submit[$h['hid']]['submit_content_slashed'] nofilter}}{{/if}}",
                            language: "{{$h['support_lang']}}"
                        });
                        $("#code_submit_section_{{$h['hid']}}").css("opacity",1);
                        {{/if}}
                        {{/foreach}}
                    });
                }
            }

        }

        function loadJsAsync2(url){
            var body = document.getElementsByTagName('body')[0];
            var jsNode = document.createElement('script');

            jsNode.setAttribute('type', 'text/javascript');
            jsNode.setAttribute('src', url);
            body.appendChild(jsNode);

            jsNode.onload = function() {
                jsCnt2++;
                if(jsCnt2==2){
                    marked.setOptions({
                        renderer: new marked.Renderer(),
                        gfm: true,
                        tables: true,
                        breaks: false,
                        pedantic: false,
                        sanitize: false,
                        smartLists: true,
                        smartypants: false,
                        highlight: function (code, lang) {
                            return hljs.highlightAuto(code, [lang]).value;
                        }
                    });
                    {{foreach $homework as $h}}
                    $("#markdown_container_{{ $h['hid'] }}").html(marked("{{$h['homework_content_slashed'] nofilter}}",{
                        sanitize: true,
                        sanitizer: DOMPurify.sanitize,
                        highlight: function (code) {
                            return hljs.highlightAuto(code).value;
                        }
                    }));
                    $("#markdown_container_{{ $h['hid'] }}").css("opacity","1");
                    {{/foreach}}
                    //hljs.initHighlighting();
                    // 链式调用VSCODE
                    loadJsAsync("{{$ATSAST_CDN}}/vscode/vs/loader.js");

                    {{foreach $homework as $h}}
                    {{ if $h['type']==2}}
                    $("#markdwon_submit_section_{{$h['hid']}}").css("opacity",1);
                    markdownEditor[{{$h['hid']}}]=new SimpleMDE({
                        element: $("#markdwon_editor_{{$h['hid']}}")[0],
                        spellChecker: false,
                        previewRender: function (plainText) {
                            return marked(plainText, {
                                sanitize: true,
                                sanitizer: DOMPurify.sanitize,
                                highlight: function (code) {
                                    return hljs.highlightAuto(code).value;
                                }
                            });
                        },
                        renderingConfig: {
                            codeSyntaxHighlighting: true
                        },
                        initialValue:"{{ if isset($homework_submit[$h['hid']]['submit_content_slashed'])}}{{$homework_submit[$h['hid']]['submit_content_slashed'] nofilter}}{{/if}}"
                    });
                    {{/if}}
                    {{/foreach}}
                }
            }
        }
        window.addEventListener("load",function() {
            {{foreach $homework as $h}}
                {{ if $h['type']==3}}
                {{ if isset($homework_submit[$h['hid']]['submit_content_slashed']) }}
                $("#file_uploade_name_{{$h['hid']}}").html("{{$homework_submit[$h['hid']]['submit_content_slashed']}}".substring("{{$homework_submit[$h['hid']]['submit_content_slashed']}}".lastIndexOf('/')+1));
                $("#file_uploade_extension_{{$h['hid']}}").attr("src","{{$ATSAST_CDN}}/img/files/"+"{{$homework_submit[$h['hid']]['submit_content_slashed']}}".substring("{{$homework_submit[$h['hid']]['submit_content_slashed']}}".lastIndexOf('.')+1)+".svg");
                $("#file_uploade_link_{{$h['hid']}}").attr("href","{{$homework_submit[$h['hid']]['submit_content_slashed']}}");
                $("#file_uploade_link_{{$h['hid']}}").removeClass("d-none");
                {{/if}}
                {{/if}}
            {{/foreach}}
            loadJsAsync2("{{$ATSAST_CDN}}/js/marked.min.js");
            loadJsAsync2("{{$ATSAST_CDN}}/js/highlight.min.js");
        }, false);

        function alert(desc) {
            var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "提示";
            $('#modeal_desc').html(desc);
            $('#modeal_title').html(title);
            $('#modal').modal();
        }

        function submit_code(ele){
            var code=editor[$(ele).attr("data-hid")].getValue();
            editor[$(ele).attr("data-hid")].updateOptions({ readOnly: true });
            $.post("{{$ATSAST_DOMAIN}}/ajax/SubmitCodes",{
                content:code,
                action:"submit",
                cid:{{$cid}},
                syid:{{$syid}},
                hid:$(ele).attr("data-hid"),
            },function(result){
                result=JSON.parse(result);
                console.log(result);
                alert(result.desc);
                if(result.ret==200) {
                    $("#btn_submit_"+$(ele).attr("data-hid")).html("再次提交");
                    $("#info_submit_"+$(ele).attr("data-hid")).html(`已于 ${result.data.time} 提交`);
                }
                editor[$(ele).attr("data-hid")].updateOptions({ readOnly: false });
            });
        }

        function submit_markdown(ele){
            var markdown_val=markdownEditor[$(ele).attr("data-hid")].value();
            $.post("{{$ATSAST_DOMAIN}}/ajax/SubmitCodes",{
                content:markdown_val,
                action:"submit",
                cid:{{$cid}},
                syid:{{$syid}},
                hid:$(ele).attr("data-hid"),
            },function(result){
                result=JSON.parse(result);
                console.log(result);
                alert(result.desc);
                if(result.ret==200) {
                    $("#btn_submit_"+$(ele).attr("data-hid")).html("再次提交");
                    $("#info_submit_"+$(ele).attr("data-hid")).html(`已于 ${result.data.time} 提交`);
                }
            });
        }


        function SubmitFile(ele) {
            var hid=$(ele).attr("data-hid");
            if(!ele.files[0]) return;
            var form = document.getElementById('file_uploade_form_'+hid);
            var data = new FormData(form);
            data.append("cid", {{$cid}});
            data.append("syid", {{$syid}});
            data.append("hid", hid);
            data.append("action", "submit");
            var files = ele.files;

            $.ajax({
                url: "{{$ATSAST_DOMAIN}}/ajax/SubmitFile",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (result) {
                    result = JSON.parse(result);
                    alert(result.desc);
                    if (result.ret == 200) {
                        $("#file_uploade_name_"+hid).html(result.data.file_name);
                        $("#file_uploade_extension_"+hid).attr("src","{{$ATSAST_CDN}}/img/files/"+result.data.file_extension+".svg");
                        $("#file_uploade_link_"+hid).attr("href",result.data.file_link);
                        $("#file_uploade_link_"+hid).removeClass("d-none");
                        $("#btn_submit_"+hid).html("再次选择文件并提交");
                        $("#info_submit_"+hid).html(`已于 ${result.data.time} 提交`);
                    }
                    var temp_input=$("#file_uploade_form_"+hid).html();
                    $("#file_uploade_form_"+hid).html("");
                    setTimeout(function(){
                        $("#file_uploade_form_"+hid).html(temp_input);
                    },10);
                },
                error: function (data) {
                    alert("上传失败");
                    var temp_input=$("#file_uploade_form_"+hid).html();
                    $("#file_uploade_form_"+hid).html("");
                    setTimeout(function(){
                        $("#file_uploade_form_"+hid).html(temp_input);
                    },10);
                }
            });
        }
    </script>
</div>

@endsection
