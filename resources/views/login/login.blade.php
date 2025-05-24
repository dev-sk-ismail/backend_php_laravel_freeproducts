<!DOCTYPE html>
<html>
    <head>
        <title>{{ trans('user/site.title')}} - {{ trans('user/site.sub-title')}}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <!-- <header>
            <div class="logo">
                <img src="{{asset('back_end/images/logo.png')}}">


            </div>
        </header>
 -->


        <div class="login-page">
            <div class="form">
                <form class="register-form" method="POST" action="{{ action([App\Http\Controllers\LoginRegistrationController::class, 'register']) }}" >
                    {{ csrf_field() }}
                    <input type="text" placeholder="name" name="name" />
                    <input type="password" placeholder="password" name="password"/>
                    <input type="text" placeholder="email address" name="email_address"/>
                    <button type="submit">create</button>
                    <p class="message">Already registered? <a href="#">Sign In</a></p>
                </form>
                <form class="login-form" action="{{ action([App\Http\Controllers\LoginRegistrationController::class, 'login']) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" placeholder="username" name="email_address" />
                    <input type="password" placeholder="password" name="password"/>
                    <button type="submit">login</button>
                    <p class="message">Not registered? <a href="#">Create an account</a></p>
                </form>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $('.message a').click(function(){
           $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
    </script>
</html>