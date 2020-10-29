<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Muda Cantik Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Vue JS -->
  <script src="{{ asset('vuejs/vue.js') }}"></script>

  <!-- Axios  -->
  <script src="{{ asset('vuejs/axios.js') }}"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" type='text/css' href="{{ asset('main/dashboard/alert-custom.css') }}">
  <link rel="stylesheet" type='text/css' href="{{ asset('main/dashboard/input-custom.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box" id="login-app">
  <input ref="baseUrl" type="hidden" value="{{ url('/') }}"/>
  <div class="login-logo">
    <a href="#"><b>MUDA</b> CANTIK</a>
  </div>
  <div v-if="showAlert" class="alert alert-dismissible"
    v-bind:class="{ 'alert-success': isSuccess, 'alert-danger': !isSuccess }">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa" v-bind:class="{ 'fa-check': isSuccess, 'fa-ban': !isSuccess }"></i> Alert!</h4>
    @{{message}}
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" :class="{'error-form-control' : usernameError}"
          @keyup="usernameKeyup" placeholder="Username" v-model="form.username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="validate-error">@{{usernameError ? 'Username is required' : ''}}</span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" :class="{'error-form-control' : passwordError}"
          @keyup="passwordKeyup" placeholder="Password" v-model="form.password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="validate-error">@{{passwordError ? 'Password is required' : ''}}</span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          {{-- <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div> --}}
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          {{-- :disabled="disableSubmit" --}}
          {{-- (!this.usernameError || !this.passwordError) ? 0 : 1 --}}
          <button type="button"  :disabled="disableSubmit" 
          class="btn btn-primary btn-block btn-flat" @click="onSubmit">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="{{ url('/admin/register') }}" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script src="{{ asset('main/dashboard/auth/login-vue.js') }}"></script>
</body>
</html>
