@extends('layouts.app')

@section('template')

<style>
    .form-control:focus,
    .form-control:hover {
        border-bottom-width: 2px;
    }

    form .form-group:last-of-type {
        margin-bottom: 0;
    }

    .alert>p {
        margin-bottom: 0;
    }

    .card {
        margin-bottom: 20vh;
        overflow: hidden;
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .card .card-header {
        padding: 0;
    }

    .card .card-header>ul {
        margin: 0;
    }

    .card .card-header>ul .nav-link {
        padding: 1rem;
        border: none!important;
    }

    .card .card-header .nav-tabs .nav-link.active {
        color: #ff4081;
    }

    .nav-tabs-material .nav-tabs-indicator {
        background-color: #ff4081;
        bottom: -1px;
        display: block;
        width: 50%;
        height: .15rem;
        position: absolute;
        transition: .2s ease-out .0s;
    }

    #accountTab {
        position: relative;
    }

    .card-footer {
        border: none;
    }

    .checkbox {
        margin-top: 1rem;
    }

    form {
        margin-bottom: 0;
    }

    input {
        box-shadow: none!important;
    }

    .was-validated input[type="checkbox"].form-control:invalid+span+span {
        color: #f44336!important;
    }

    label[for="agreement"] {
        display: inline-block;
    }

    .card-bottom{
        background-color:rgb(244,244,244);
        padding:10px;
    }

    .socialite-section a{
        color: inherit;
    }
</style>
<div class="container mundb-standard-container">
    <div class="row justify-content-sm-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="text-center" style="margin-top:10vh;margin-bottom:20px;">
                <h1 style="padding:20px;display:inline-block;">@SAST</h1>
                <p>Auxiliary Teaching for SAST</p>
            </div>
            <div class="alert alert-primary text-left" role="alert">
                由于后台系统重构，2019年8月前注册的用户请<a href="{{$ATSAST_DOMAIN}}/account/update">点击这里</a>更新密码。
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs nav-justified nav-tabs-material" id="accountTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">使用您的ATSAST账号登录</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">注册一个新的ATSAST账号</a>
                        </li>
                        <div class="nav-tabs-indicator" id="nav-tabs-indicator" style="left: 0px;"></div>
                    </ul>
                </div>
                <div class="tab-content" id="accountTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form class="needs-validation" action="{{ $ATSAST_DOMAIN.route('login',null,false) }}" method="post" id="login_form" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email" class="bmd-label-floating">电子邮箱</label>
                                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password" class="bmd-label-floating">密码</label>
                                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="remember"><input class="form-control" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span>记住我</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ $ATSAST_DOMAIN.route('password.request',null,false) }}"><button type="button" class="btn btn-secondary">忘记密码？</button></a>
                                <button type="submit" class="btn btn-danger">登录</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load",function() {
        $('#login-tab').on('click', function (e) {
            e.preventDefault();
        })
        $('#register-tab').on('click', function (e) {
            e.preventDefault();
            location.href="{{$ATSAST_DOMAIN}}/register";
        })

        $('input:-webkit-autofill').each(function(){
            if ($(this).val().length !== "") {
                console.log($(this).siblings('label'));
                $(this).siblings('label').addClass('active');
                $(this).parent().addClass('is-filled');
            }
        });

    }, false);

</script>

@endsection
