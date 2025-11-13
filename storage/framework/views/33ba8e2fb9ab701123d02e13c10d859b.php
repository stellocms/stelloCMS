<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - <?php echo e(cms_name()); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('themes/adminlte/css/custom.css')); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <img src="<?php echo e(asset('img/icon/logo_96x96.png')); ?>" alt="<?php echo e(cms_name()); ?> Logo" style="height: 50px; margin-right: 10px; vertical-align: middle;">
            <b><?php echo e(cms_name()); ?></b>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silakan login untuk melanjutkan</p>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('panel.login')); ?>" id="loginForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="input-group mb-3">
                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                        <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                            <span id="togglePassword" class="fas fa-eye"></span>
                        </div>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <!-- Captcha Matematika -->
                <div class="input-group mb-3">
                    <div class="form-control text-center" style="background-color: #f8f9fa; display: flex; align-items: center; justify-content: space-between; padding-left: 10px; padding-right: 10px;">
                        <span id="captcha-equation">
                        <?php
                            $num1 = rand(1, 20);
                            $num2 = rand(1, 20);
                            $operation = ['+', '-', '*'][array_rand(['+', '-', '*'])];
                            
                            switch ($operation) {
                                case '+':
                                    $result = $num1 + $num2;
                                    break;
                                case '-':
                                    // Pastikan hasil tidak negatif
                                    if ($num1 < $num2) {
                                        list($num1, $num2) = [$num2, $num1];
                                    }
                                    $result = $num1 - $num2;
                                    break;
                                case '*':
                                    $num1 = rand(1, 10);
                                    $num2 = rand(1, 10);
                                    $result = $num1 * $num2;
                                    break;
                            }
                            
                            $captcha_equation = "$num1 $operation $num2 = ?";
                            session(['captcha_result' => $result]);
                        ?>
                            <?php echo e($captcha_equation); ?>

                        </span>
                        <span style="cursor: pointer; margin-left: 10px;" onclick="refreshCaptcha()" title="Refresh Captcha">
                            <i class="fas fa-sync-alt"></i>
                        </span>
                    </div>
                    <input type="number" class="form-control <?php $__errorArgs = ['captcha_input'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="captcha_input" name="captcha_input" placeholder="Jawaban" required>
                    <?php $__errorArgs = ['captcha_input'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Anti-automation measures -->
                <input type="hidden" name="client_time" id="client_time">
                <script>
                    document.getElementById('client_time').value = new Date().getTime();
                </script>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <label for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!-- <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div> -->
            <!-- /.social-auth-links -->

            <!-- <p class="mb-1">
                <a href="#">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="#" class="text-center">Register a new membership</a>
            </p> -->
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>

<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    var toggleIcon = document.getElementById("togglePassword");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

function refreshCaptcha() {
    fetch('<?php echo e(route('captcha.refresh')); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('captcha-equation').textContent = data.equation;
                document.getElementById('captcha_input').value = '';
            }
        })
        .catch(error => {
            console.error('Error refreshing captcha:', error);
        });
}
</script>
</body>
</html><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/auth/login.blade.php ENDPATH**/ ?>