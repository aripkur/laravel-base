
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Login</title>
    <link rel="icon" href="/assets/image/icon-app.png" type="image/icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/css/login.css">

    <script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/adminlte/js/adminlte.min.js"></script>
</head>
<body class="hold-transition login-page wrapper">
<div class="login-box">

  <div class="card">
        <div class="card-header text-center">
            <h2 class="font-weight-bold">{{ str_replace("-", " ", config("app.name"))}}</h2>
        </div>
        <div class="card-body">
            @if(session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
            @endif
            <form action={{ route('login.verif') }} method="post">
                @csrf
                <div class="form-group">
                    <label>Username </label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label>Password </label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Captcha code </label>
                            <input type="hidden" id="captcha_id" name="captcha_id">
                            <image src="" id="captcha_img" class="border rounded"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Captcha </label>
                            <input type="text" id="captcha" name="captcha" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </form>
        </div>

  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        loadCaptchaImage()
    })
    function loadCaptchaImage() {
        $.ajax({
            method: 'GET',
            url: window.origin + '/api/captcha',
            success: function (result) {
                $("#captcha_id").val(result.data.id);
                $("#captcha").val('');
                $("#captcha_img").attr("src", result.data.file);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.status == 429){
                    $("#status").addClass("alert alert-danger")
                    $("#status").html(jqXHR.responseJSON?.metadata?.message || "Request terlalu banyak")
                }
            },
        });
    }

</script>
</body>
</html>
