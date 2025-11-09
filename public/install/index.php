<?php
session_start();

// Menentukan langkah instalasi
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Fungsi untuk memeriksa ekstensi PHP
function check_php_extension($extension) {
    return extension_loaded($extension);
}

// Fungsi untuk mendapatkan versi PHP
function get_php_version() {
    return phpversion();
}

// Fungsi untuk memeriksa versi minimum PHP
function check_php_version($min_version = '8.2.0') {
    return version_compare(phpversion(), $min_version, '>=');
}

// Fungsi untuk memeriksa writable directory
function is_writable_recursive($dir) {
    if (!is_dir($dir)) return false;
    if (!is_writable($dir)) return false;
    
    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $object)) {
                if (!is_writable_recursive($dir . DIRECTORY_SEPARATOR . $object)) {
                    return false;
                }
            } else {
                if (!is_writable($dir . DIRECTORY_SEPARATOR . $object)) {
                    return false;
                }
            }
        }
    }
    return true;
}

// Fungsi untuk memeriksa dan membuat file .env jika belum ada
function ensure_env_file() {
    $env_path = __DIR__ . '/../../.env';
    $env_example_path = __DIR__ . '/../../.env.example';
    
    if (!file_exists($env_path)) {
        if (file_exists($env_example_path)) {
            copy($env_example_path, $env_path);
        } else {
            // Buat .env default jika tidak ada
            $default_env = "APP_NAME=stelloCMS
APP_ENV=local
APP_KEY=base64:JHXyRZl9vJ2fYdN5zE8G7K6B3Q4wA1sX2VcP5mRtIbO=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost/stelloCMS/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stellocms
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_CONNECTION=pusher
CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=\"hello@example.com\"
MAIL_FROM_NAME=\"\${APP_NAME}\"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME=\"\${APP_NAME}\"

ADMIN_THEME=adminlte
FRONTEND_THEME=kind_heart

# CMS Configuration
CMS_NAME=stelloCMS
CMS_DESCRIPTION=\"Limitless Online Content Management\"
CMS_TEAM=\"stelloCMS Development Team\"
";
            file_put_contents($env_path, $default_env);
        }
    }
}

// Pastikan .env file ada
ensure_env_file();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instalasi stelloCMS - Tahap <?php echo $step; ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/icon/favicon.ico" type="image/x-icon">
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../themes/adminlte/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <style>
        .main-header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 10px 20px;
        }
        .header-brand {
            display: flex;
            align-items: center;
        }
        .header-logo {
            height: 50px;
            width: auto;
            margin-right: 15px;
        }
        .header-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step-dot {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            color: #6c757d;
            font-size: 30px;
        }
        .step-dot.active {
            background-color: #007bff;
            color: white;
        }
        .step-line {
            flex: 1;
            height: 2px;
            background-color: #e9ecef;
            position: relative;
            top: 14px;
            margin: 0 -10px;
        }
        .step-content {
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .requirement-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .requirement-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 10px;
        }
        .status-ok {
            background-color: #d4edda;
            color: #155724;
        }
        .status-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body class="hold-transition">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
        <div class="header-brand">
            <img src="../img/icon/logo_96x96.png" alt="stelloCMS Logo" class="header-logo">
            <h1 class="header-title">stelloCMS</h1>
        </div>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Instalasi stelloCMS</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Step indicator -->
                        <div class="step-indicator">
                            <div class="step-dot <?php echo $step >= 1 ? 'active' : ''; ?>">1</div>
                            <div class="step-line"></div>
                            <div class="step-dot <?php echo $step >= 2 ? 'active' : ''; ?>">2</div>
                            <div class="step-line"></div>
                            <div class="step-dot <?php echo $step >= 3 ? 'active' : ''; ?>">3</div>
                            <div class="step-line"></div>
                            <div class="step-dot <?php echo $step >= 4 ? 'active' : ''; ?>">4</div>
                            <div class="step-line"></div>
                            <div class="step-dot <?php echo $step >= 5 ? 'active' : ''; ?>">5</div>
                        </div>

                        <!-- Step content -->
                        <?php if ($step == 1): ?>
                        <div class="step-content">
                            <h3>Tahap 1: Persyaratan Server</h3>
                            <p>Harap pastikan semua persyaratan berikut terpenuhi sebelum melanjutkan instalasi.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Persyaratan PHP:</h5>
                                    <div class="requirement-item">
                                        <strong>Versi PHP</strong>
                                        <span class="requirement-status <?php echo check_php_version() ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo get_php_version(); ?> (Minimal 8.2.0)
                                            <?php echo check_php_version() ? '✓' : '✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi OpenSSL</strong>
                                        <span class="requirement-status <?php echo check_php_extension('openssl') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('openssl') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi PDO</strong>
                                        <span class="requirement-status <?php echo check_php_extension('PDO') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('PDO') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi Mbstring</strong>
                                        <span class="requirement-status <?php echo check_php_extension('mbstring') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('mbstring') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5>Persyaratan Tambahan:</h5>
                                    <div class="requirement-item">
                                        <strong>Ekstensi Tokenizer</strong>
                                        <span class="requirement-status <?php echo check_php_extension('tokenizer') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('tokenizer') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi XML</strong>
                                        <span class="requirement-status <?php echo check_php_extension('xml') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('xml') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi Ctype</strong>
                                        <span class="requirement-status <?php echo check_php_extension('ctype') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('ctype') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>Ekstensi JSON</strong>
                                        <span class="requirement-status <?php echo check_php_extension('json') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo check_php_extension('json') ? 'Tersedia ✓' : 'Tidak Tersedia ✗'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>Izin Akses Direktori:</h5>
                                    <div class="requirement-item">
                                        <strong>bootstrap/cache</strong>
                                        <span class="requirement-status <?php echo is_writable(__DIR__ . '/../../bootstrap/cache') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo is_writable(__DIR__ . '/../../bootstrap/cache') ? 'Writable ✓' : 'Not Writable ✗'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="requirement-item">
                                        <strong>storage</strong>
                                        <span class="requirement-status <?php echo is_writable(__DIR__ . '/../../storage') ? 'status-ok' : 'status-error'; ?>">
                                            <?php echo is_writable(__DIR__ . '/../../storage') ? 'Writable ✓' : 'Not Writable ✗'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button 
                                        id="nextBtn" 
                                        class="btn btn-primary float-right" 
                                        <?php echo !(check_php_version() && check_php_extension('openssl') && check_php_extension('PDO') && check_php_extension('mbstring') && check_php_extension('tokenizer') && check_php_extension('xml') && check_php_extension('ctype') && check_php_extension('json') && is_writable(__DIR__ . '/../../bootstrap/cache') && is_writable(__DIR__ . '/../../storage')) ? 'disabled' : ''; ?>>
                                        Lanjut <i class="fas fa-arrow-right"></i>
                                    </button>
                                    
                                    <?php if (!(check_php_version() && check_php_extension('openssl') && check_php_extension('PDO') && check_php_extension('mbstring') && check_php_extension('tokenizer') && check_php_extension('xml') && check_php_extension('ctype') && check_php_extension('json'))) : ?>
                                    <div class="alert alert-warning mt-3">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                                        <p>Beberapa persyaratan belum terpenuhi. Harap instal dan aktifkan ekstensi PHP yang diperlukan sebelum melanjutkan.</p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                        document.getElementById('nextBtn').addEventListener('click', function() {
                            window.location.href = '?step=2';
                        });
                        </script>
                        
                        <?php elseif ($step == 2): ?>
                        <?php
                        // Baca konfigurasi dari .env
                        $env_path = __DIR__ . '/../../.env';
                        $env_content = file_get_contents($env_path);
                        
                        // Ekstrak konfigurasi database
                        preg_match("/DB_CONNECTION=(.*)/", $env_content, $connection_match);
                        preg_match("/DB_HOST=(.*)/", $env_content, $host_match);
                        preg_match("/DB_PORT=(.*)/", $env_content, $port_match);
                        preg_match("/DB_DATABASE=(.*)/", $env_content, $database_match);
                        preg_match("/DB_USERNAME=(.*)/", $env_content, $username_match);
                        preg_match("/DB_PASSWORD=(.*)/", $env_content, $password_match);
                        
                        $db_connection = isset($connection_match[1]) ? $connection_match[1] : 'mysql';
                        $db_host = isset($host_match[1]) ? $host_match[1] : '127.0.0.1';
                        $db_port = isset($port_match[1]) ? $port_match[1] : '3306';
                        $db_database = isset($database_match[1]) ? $database_match[1] : 'stellocms';
                        $db_username = isset($username_match[1]) ? $username_match[1] : 'root';
                        $db_password = isset($password_match[1]) ? $password_match[1] : '';
                        
                        // Coba koneksi ke database
                        $connection_success = false;
                        $database_exists = false;
                        
                        if ($db_connection === 'mysql') {
                            $mysqli = @new mysqli($db_host, $db_username, $db_password, '', (int)$db_port);
                            if (!$mysqli->connect_error) {
                                $connection_success = true;
                                
                                // Cek apakah database exists
                                $result = $mysqli->query("SHOW DATABASES LIKE '$db_database'");
                                if ($result && $result->num_rows > 0) {
                                    $database_exists = true;
                                }
                            }
                        }
                        ?>
                        <div class="step-content">
                            <h3>Tahap 2: Konfigurasi Database</h3>
                            <p>Harap periksa konfigurasi database Anda. Jika database belum tersedia, Anda dapat membuatnya melalui instalasi.</p>
                            
                            <form id="databaseForm" method="post" action="?step=3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="db_connection">Driver Database:</label>
                                            <input type="text" class="form-control" id="db_connection" name="db_connection" value="<?php echo htmlspecialchars($db_connection); ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="db_host">Host Database:</label>
                                            <input type="text" class="form-control" id="db_host" name="db_host" value="<?php echo htmlspecialchars($db_host); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="db_port">Port Database:</label>
                                            <input type="number" class="form-control" id="db_port" name="db_port" value="<?php echo htmlspecialchars($db_port); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="db_database">Nama Database:</label>
                                            <input type="text" class="form-control" id="db_database" name="db_database" value="<?php echo htmlspecialchars($db_database); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="db_username">Username Database:</label>
                                            <input type="text" class="form-control" id="db_username" name="db_username" value="<?php echo htmlspecialchars($db_username); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="db_password">Password Database:</label>
                                            <input type="password" class="form-control" id="db_password" name="db_password" value="<?php echo htmlspecialchars($db_password); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <?php if ($connection_success): ?>
                                            <div class="alert alert-success">
                                                <h5><i class="icon fas fa-check"></i> Koneksi Berhasil!</h5>
                                                <p>Koneksi ke server database berhasil. <?php echo $database_exists ? 'Database <strong>' . htmlspecialchars($db_database) . '</strong> sudah tersedia.' : 'Database <strong>' . htmlspecialchars($db_database) . '</strong> belum tersedia.'; ?></p>
                                            </div>
                                            
                                            <?php if ($database_exists): ?>
                                                <button type="submit" name="action" value="update" class="btn btn-warning float-right">
                                                    <i class="fas fa-sync-alt"></i> Update Database
                                                </button>
                                            <?php else: ?>
                                                <button type="submit" name="action" value="install" class="btn btn-success float-right">
                                                    <i class="fas fa-database"></i> Instal Database
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="alert alert-danger">
                                                <h5><i class="icon fas fa-ban"></i> Koneksi Gagal!</h5>
                                                <p>Tidak dapat terhubung ke server database. Harap periksa kembali konfigurasi Anda.</p>
                                            </div>
                                            <button type="submit" name="action" value="install" class="btn btn-success float-right" disabled>
                                                <i class="fas fa-database"></i> Instal Database
                                            </button>
                                        <?php endif; ?>
                                        
                                        <a href="?step=1" class="btn btn-secondary float-left">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <?php elseif ($step == 3): ?>
                        <?php
                        // Proses form dari tahap 2
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $db_connection = $_POST['db_connection'] ?? 'mysql';
                            $db_host = $_POST['db_host'] ?? '127.0.0.1';
                            $db_port = $_POST['db_port'] ?? '3306';
                            $db_database = $_POST['db_database'] ?? 'stellocms';
                            $db_username = $_POST['db_username'] ?? 'root';
                            $db_password = $_POST['db_password'] ?? '';
                            
                            // Update .env file DULU sebelum membuat koneksi
                            $env_path = __DIR__ . '/../../.env';
                            $env_content = file_get_contents($env_path);
                            
                            $env_content = preg_replace("/^DB_CONNECTION=.*/m", "DB_CONNECTION=$db_connection", $env_content);
                            $env_content = preg_replace("/^DB_HOST=.*/m", "DB_HOST=$db_host", $env_content);
                            $env_content = preg_replace("/^DB_PORT=.*/m", "DB_PORT=$db_port", $env_content);
                            $env_content = preg_replace("/^DB_DATABASE=.*/m", "DB_DATABASE=$db_database", $env_content);
                            $env_content = preg_replace("/^DB_USERNAME=.*/m", "DB_USERNAME=$db_username", $env_content);
                            $env_content = preg_replace("/^DB_PASSWORD=.*/m", "DB_PASSWORD=$db_password", $env_content);
                            
                            file_put_contents($env_path, $env_content);
                            
                            // Simpan data ke session
                            $_SESSION['db_config'] = [
                                'connection' => $db_connection,
                                'host' => $db_host,
                                'port' => $db_port,
                                'database' => $db_database,
                                'username' => $db_username,
                                'password' => $db_password
                            ];
                            
                            // LANGKAH PERTAMA: Lakukan pengecekan koneksi terlebih dahulu
                            $connection_test = new mysqli($db_host, $db_username, $db_password, '', (int)$db_port);
                            
                            if ($connection_test->connect_error) {
                                // Jika koneksi gagal, simpan error dan redirect ke step 2
                                $_SESSION['connection_error'] = $connection_test->connect_error;
                                header('Location: ?step=2');
                                exit();
                            } else {
                                // Jika koneksi berhasil, lanjutkan ke proses database
                                $connection_test->close();
                                
                                // Buat koneksi baru untuk operasi instalasi
                                $mysqli = new mysqli($db_host, $db_username, $db_password, '', (int)$db_port);
                                
                                // Cek apakah database sudah ada
                                $db_check_result = $mysqli->query("SHOW DATABASES LIKE '$db_database'");
                                $db_exists = $db_check_result && $db_check_result->num_rows > 0;
                                
                                if ($db_exists) {
                                    // Jika database sudah ada, pilih database dan instal query
                                    $mysqli->select_db($db_database);
                                    
                                    // Eksekusi queries dari file PHP untuk instalasi database
                                    $queries_file = __DIR__ . '/queries.php';
                                    if (file_exists($queries_file)) {
                                        require_once $queries_file;
                                        
                                        $errors = [];
                                        foreach ($sql_queries as $query) {
                                            if (!$mysqli->query($query)) {
                                                $errors[] = $mysqli->error . " [Query: " . substr($query, 0, 100) . "...]";
                                            }
                                        }
                                        
                                        if (empty($errors)) {
                                            $_SESSION['installation_status'] = 'success';
                                            $_SESSION['action_performed'] = 'install';
                                        } else {
                                            $_SESSION['installation_status'] = 'error';
                                            $_SESSION['errors'] = $errors;
                                        }
                                    } else {
                                        $_SESSION['installation_status'] = 'error';
                                        $_SESSION['errors'] = ['File queries.php tidak ditemukan'];
                                    }
                                } else {
                                    // Jika database belum ada, buat database terlebih dahulu
                                    $create_db_sql = "CREATE DATABASE `$db_database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
                                    if ($mysqli->query($create_db_sql)) {
                                        // Pilih database yang baru dibuat
                                        $mysqli->select_db($db_database);
                                        
                                        // Eksekusi queries dari file PHP untuk instalasi database
                                        $queries_file = __DIR__ . '/queries.php';
                                        if (file_exists($queries_file)) {
                                            require_once $queries_file;
                                            
                                            $errors = [];
                                            foreach ($sql_queries as $query) {
                                                if (!$mysqli->query($query)) {
                                                    $errors[] = $mysqli->error . " [Query: " . substr($query, 0, 100) . "...]";
                                                }
                                            }
                                            
                                            if (empty($errors)) {
                                                $_SESSION['installation_status'] = 'success';
                                                $_SESSION['action_performed'] = 'install';
                                            } else {
                                                $_SESSION['installation_status'] = 'error';
                                                $_SESSION['errors'] = $errors;
                                            }
                                        } else {
                                            $_SESSION['installation_status'] = 'error';
                                            $_SESSION['errors'] = ['File queries.php tidak ditemukan'];
                                        }
                                    } else {
                                        $_SESSION['installation_status'] = 'error';
                                        $_SESSION['errors'] = ['Gagal membuat database: ' . $mysqli->error];
                                    }
                                }
                                $mysqli->close();
                            }
                        }
                        
                        // Tampilkan modal error jika ada error koneksi dari session
                        if (isset($_SESSION['connection_error'])) {
                            $connection_error = $_SESSION['connection_error'];
                            unset($_SESSION['connection_error']);
                            ?>
                            <!-- Modal Error Koneksi -->
                            <div class="modal fade" id="connectionErrorModal" tabindex="-1" role="dialog" aria-labelledby="connectionErrorModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="connectionErrorModalLabel"><i class="fas fa-exclamation-triangle"></i> Koneksi Gagal</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>Terjadi kesalahan saat mencoba terhubung ke server database:</p>
                                            <div class="alert alert-danger">
                                                <strong><?php echo htmlspecialchars($connection_error); ?></strong>
                                            </div>
                                            <p>Harap periksa kembali konfigurasi database Anda:</p>
                                            <ul>
                                                <li>Host database benar dan server database aktif</li>
                                                <li>Port database benar (default: 3306)</li>
                                                <li>Username dan password database benar</li>
                                                <li>Database dapat diakses dengan kredensial yang diberikan</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="?step=2" class="btn btn-primary">Perbaiki Konfigurasi <i class="fas fa-cog"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            $(document).ready(function(){
                                $('#connectionErrorModal').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });
                                $('#connectionErrorModal').modal('show');
                            });
                            </script>
                            <?php
                        }
                        
                        if (isset($_SESSION['installation_status'])) {
                            if ($_SESSION['installation_status'] === 'success') {
                                $action_performed = $_SESSION['action_performed'];
                                unset($_SESSION['installation_status'], $_SESSION['action_performed']);
                                ?>
                                <div class="step-content">
                                    <h3>Tahap 3: Instalasi Database</h3>
                                    <div class="alert alert-success">
                                        <h5><i class="icon fas fa-check"></i> <?php echo ucfirst($action_performed); ?> Database Berhasil!</h5>
                                        <p>Database berhasil <?php echo $action_performed === 'install' ? 'dibuat dan tabel-tabel telah dibuat' : 'diupdate'; ?>.</p>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="?step=4" class="btn btn-primary float-right">
                                                Lanjut ke Tahap 4 <i class="fas fa-arrow-right"></i>
                                            </a>
                                            <a href="?step=2" class="btn btn-secondary float-left">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $errors = $_SESSION['errors'] ?? ['Terjadi kesalahan yang tidak diketahui'];
                                unset($_SESSION['installation_status'], $_SESSION['errors']);
                                ?>
                                <div class="step-content">
                                    <h3>Tahap 3: Instalasi Database</h3>
                                    <div class="alert alert-danger">
                                        <h5><i class="icon fas fa-ban"></i> Instalasi Database Gagal!</h5>
                                        <p>Terjadi kesalahan saat <?php echo $action === 'install' ? 'membuat' : 'mengupdate'; ?> database:</p>
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="?step=2" class="btn btn-warning float-right">
                                                <i class="fas fa-redo"></i> Coba Lagi
                                            </a>
                                            <a href="?step=2" class="btn btn-secondary float-left">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // Jika belum ada submit, tampilkan form sebelumnya
                            ?>
                            <div class="step-content">
                                <h3>Tahap 3: Instalasi Database</h3>
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info-circle"></i> Proses Instalasi Database</h5>
                                    <p>Sedang memproses instalasi database...</p>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                
                                <script>
                                setTimeout(function() {
                                    window.location.href = '?step=2';
                                }, 2000);
                                </script>
                            </div>
                            <?php
                        }
                        ?>
                        
                        <?php elseif ($step == 4): ?>
                        <div class="step-content">
                            <h3>Tahap 4: Konfigurasi Pengaturan Web</h3>
                            <p>Masukkan konfigurasi dasar website Anda:</p>
                            
                            <form id="settingsForm" method="post" action="?step=5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="web_name">Nama Website:</label>
                                            <input type="text" class="form-control" id="web_name" name="web_name" placeholder="Contoh: Website Resmi PT. Suka Sejahtera" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="web_description">Deskripsi Website:</label>
                                            <textarea class="form-control" id="web_description" name="web_description" rows="3" placeholder="Deskripsi singkat tentang website Anda..."></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="web_keywords">Keywords Website:</label>
                                            <input type="text" class="form-control" id="web_keywords" name="web_keywords" placeholder="keyword1, keyword2, keyword3...">
                                            <small class="form-text text-muted">Pisahkan dengan koma (,)</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="web_address">Alamat Website:</label>
                                            <input type="text" class="form-control" id="web_address" name="web_address" placeholder="Contoh: Jl. Raya No. 1 Desa Makmur, Kec. Maju Jaya">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="web_phone">Nomor Telepon:</label>
                                            <input type="text" class="form-control" id="web_phone" name="web_phone" placeholder="Contoh: +62 123 4567 890">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="admin_name">Nama Lengkap Administrator:</label>
                                            <input type="text" class="form-control" id="admin_name" name="admin_name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="admin_email">Email Administrator:</label>
                                            <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="admin_password">Password Administrator:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="admin_password_confirm">Konfirmasi Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="admin_password_confirm" name="admin_password_confirm" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="togglePasswordConfirm" style="cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success float-right">
                                            Simpan Pengaturan & Buat Akun <i class="fas fa-save"></i>
                                        </button>
                                        <a href="?step=3" class="btn btn-secondary float-left">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </form>
                            
                            <script>
                            document.getElementById('togglePassword').addEventListener('click', function() {
                                const passwordField = document.getElementById('admin_password');
                                const icon = this.querySelector('i');
                                
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            
                            document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
                                const passwordField = document.getElementById('admin_password_confirm');
                                const icon = this.querySelector('i');
                                
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            
                            document.getElementById('settingsForm').addEventListener('submit', function(e) {
                                const password = document.getElementById('admin_password');
                                const confirmPassword = document.getElementById('admin_password_confirm');
                                
                                if (password.value !== confirmPassword.value) {
                                    e.preventDefault();
                                    alert('Password dan Konfirmasi Password tidak cocok!');
                                    return false;
                                }
                                
                                if (password.value.length < 6) {
                                    e.preventDefault();
                                    alert('Password minimal 6 karakter!');
                                    return false;
                                }
                            });
                            </script>
                        </div>
                            
                            <script>
                            document.getElementById('togglePassword').addEventListener('click', function() {
                                const passwordField = document.getElementById('admin_password');
                                const icon = this.querySelector('i');
                                
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            
                            document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
                                const passwordField = document.getElementById('admin_password_confirm');
                                const icon = this.querySelector('i');
                                
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            
                            document.getElementById('adminForm').addEventListener('submit', function(e) {
                                const password = document.getElementById('admin_password').value;
                                const confirmPassword = document.getElementById('admin_password_confirm').value;
                                
                                if (password !== confirmPassword) {
                                    e.preventDefault();
                                    alert('Password dan Konfirmasi Password tidak cocok!');
                                    return false;
                                }
                                
                                if (password.length < 6) {
                                    e.preventDefault();
                                    alert('Password minimal 6 karakter!');
                                    return false;
                                }
                            });
                            </script>
                        </div>
                        
                        <?php elseif ($step == 5): ?>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Ambil data dari form pengaturan
                            $web_name = $_POST['web_name'] ?? '';
                            $web_description = $_POST['web_description'] ?? '';
                            $web_keywords = $_POST['web_keywords'] ?? '';
                            $web_address = $_POST['web_address'] ?? '';
                            $web_phone = $_POST['web_phone'] ?? '';
                            
                            // Ambil data admin
                            $admin_name = $_POST['admin_name'] ?? '';
                            $admin_email = $_POST['admin_email'] ?? '';
                            $admin_password = $_POST['admin_password'] ?? '';
                            
                            // Hash password
                            $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
                            
                            // Ambil konfigurasi database dari session
                            $db_config = $_SESSION['db_config'] ?? null;
                            
                            if ($db_config) {
                                // Konek ke database
                                $mysqli = new mysqli(
                                    $db_config['host'], 
                                    $db_config['username'], 
                                    $db_config['password'], 
                                    $db_config['database'], 
                                    (int)$db_config['port']
                                );
                                
                                if (!$mysqli->connect_error) {
                                    // Masukkan pengaturan ke tabel settings
                                    $settings_data = [
                                        ['pengaturan' => 'nama-web', 'nilai' => $web_name, 'status' => 'aktif'],
                                        ['pengaturan' => 'deskripsi-web', 'nilai' => $web_description, 'status' => 'aktif'],
                                        ['pengaturan' => 'keywords-web', 'nilai' => $web_keywords, 'status' => 'aktif'],
                                        ['pengaturan' => 'alamat-web', 'nilai' => $web_address, 'status' => 'aktif'],
                                        ['pengaturan' => 'no-telephone', 'nilai' => $web_phone, 'status' => 'aktif']
                                    ];
                                    
                                    foreach ($settings_data as $setting) {
                                        $insert_setting_sql = "INSERT INTO settings (pengaturan, nilai, status) VALUES (?, ?, ?)";
                                        $stmt = $mysqli->prepare($insert_setting_sql);
                                        if ($stmt) {
                                            $stmt->bind_param("sss", $setting['pengaturan'], $setting['nilai'], $setting['status']);
                                            $stmt->execute();
                                            $stmt->close();
                                        }
                                    }
                                    
                                    // Cek apakah tabel users ada dan masukkan data admin
                                    $check_table_sql = "SHOW TABLES LIKE 'users'";
                                    $result = $mysqli->query($check_table_sql);
                                    
                                    if ($result->num_rows > 0) {
                                        // Masukkan user admin ke tabel users
                                        $insert_sql = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, 1)";
                                        $stmt = $mysqli->prepare($insert_sql);
                                        if ($stmt) {
                                            $stmt->bind_param("sss", $admin_name, $admin_email, $hashed_password);
                                            if ($stmt->execute()) {
                                                $_SESSION['admin_created'] = true;
                                                $_SESSION['admin_info'] = [
                                                    'name' => $admin_name,
                                                    'email' => $admin_email
                                                ];
                                            } else {
                                                $_SESSION['admin_created'] = false;
                                                $_SESSION['error_message'] = 'Gagal membuat akun admin: ' . $stmt->error;
                                            }
                                            $stmt->close();
                                        } else {
                                            $_SESSION['admin_created'] = false;
                                            $_SESSION['error_message'] = 'Gagal menyiapkan statement: ' . $mysqli->error;
                                        }
                                    } else {
                                        $_SESSION['admin_created'] = false;
                                        $_SESSION['error_message'] = 'Tabel users tidak ditemukan. Pastikan database telah diinstal dengan benar.';
                                    }
                                    
                                    $mysqli->close();
                                } else {
                                    $_SESSION['admin_created'] = false;
                                    $_SESSION['error_message'] = 'Gagal terhubung ke database: ' . $mysqli->connect_error;
                                }
                            } else {
                                $_SESSION['admin_created'] = false;
                                $_SESSION['error_message'] = 'Konfigurasi database tidak ditemukan.';
                            }
                        }
                        
                        if (isset($_SESSION['admin_created'])) {
                            if ($_SESSION['admin_created']) {
                                // Hapus session setelah digunakan
                                unset($_SESSION['admin_created'], $_SESSION['db_config']);
                                ?>
                                <div class="step-content">
                                    <h3>Tahap 5: Instalasi Selesai</h3>
                                    <div class="alert alert-success">
                                        <h5><i class="icon fas fa-check"></i> Instalasi Berhasil!</h5>
                                        <p>Akun administrator telah berhasil dibuat.</p>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Informasi Akun Administrator</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Nama:</strong> <?php echo htmlspecialchars($_SESSION['admin_info']['name']); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['admin_info']['email']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="../panel" class="btn btn-primary float-right">
                                                Login ke Panel <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                unset($_SESSION['admin_info']);
                            } else {
                                $error_msg = $_SESSION['error_message'] ?? 'Terjadi kesalahan yang tidak diketahui';
                                unset($_SESSION['admin_created'], $_SESSION['error_message']);
                                ?>
                                <div class="step-content">
                                    <h3>Tahap 5: Instalasi Gagal</h3>
                                    <div class="alert alert-danger">
                                        <h5><i class="icon fas fa-ban"></i> Pembuatan Akun Administrator Gagal!</h5>
                                        <p><?php echo htmlspecialchars($error_msg); ?></p>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="?step=4" class="btn btn-warning float-right">
                                                <i class="fas fa-redo"></i> Coba Lagi
                                            </a>
                                            <a href="?step=4" class="btn btn-secondary float-left">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            // Jika belum submit form, redirect ke tahap 4
                            header('Location: ?step=4');
                            exit;
                        }
                        ?>
                        
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <footer class="main-footer text-center">
        <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://stellocms.com">stelloCMS</a>.</strong> All rights reserved.
        <div class="mt-2">
            <small>Version 1.0.0</small>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../themes/adminlte/js/adminlte.min.js"></script>
</body>
</html>