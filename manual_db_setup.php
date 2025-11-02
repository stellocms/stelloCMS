<?php
// manual_db_setup.php - Manual database setup

// Set the working directory
chdir(dirname(__FILE__));

// Load composer autoloader
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Initialize Laravel application
    $app = require_once 'bootstrap/app.php';
    
    // Register the application with the console kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Get the database connection
    $db = $app->make('db');
    
    // Test the connection
    echo "Testing database connection...\n";
    $pdo = $db->connection()->getPdo();
    echo "Connection successful!\n";
    
    // Create the migrations table if it doesn't exist
    if (!$db->getSchemaBuilder()->hasTable('migrations')) {
        echo "Creating migrations table...\n";
        $db->getSchemaBuilder()->create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration')->unique();
            $table->integer('batch');
        });
    }
    
    // Run the individual migration files manually
    // We'll execute the up() methods of our migration files
    
    // Run the users table migration
    if (!$db->getSchemaBuilder()->hasTable('users')) {
        echo "Creating users table...\n";
        $db->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    
    // Run roles table migration
    if (!$db->getSchemaBuilder()->hasTable('roles')) {
        echo "Creating roles table...\n";
        $db->getSchemaBuilder()->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
    
    // Add role_id column to users if it doesn't exist
    if (!$db->getSchemaBuilder()->hasColumn('users', 'role_id')) {
        echo "Adding role_id column to users table...\n";
        $db->getSchemaBuilder()->table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
    
    // Create plugins table
    if (!$db->getSchemaBuilder()->hasTable('plugins')) {
        echo "Creating plugins table...\n";
        $db->getSchemaBuilder()->create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('active')->default(false);
            $table->boolean('installed')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
    
    // Create berita_desa table
    if (!$db->getSchemaBuilder()->hasTable('berita_desa')) {
        echo "Creating berita_desa table...\n";
        $db->getSchemaBuilder()->create('berita_desa', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->timestamp('tanggal_publikasi')->useCurrent();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }
    
    // Insert default roles
    $roleModel = new class extends Illuminate\Database\Eloquent\Model {
        protected $table = 'roles';
        protected $fillable = ['name'];
        public $timestamps = true;
    };
    
    $roles = [
        'admin', 'kepala-desa', 'sekdes', 'kaur',
        'kadus', 'rw', 'rt', 'warga'
    ];
    
    echo "Inserting default roles...\n";
    foreach ($roles as $roleName) {
        $roleModel->firstOrCreate(['name' => $roleName]);
    }
    
    // Insert default admin user
    $userModel = new class extends Illuminate\Database\Eloquent\Model {
        protected $table = 'users';
        protected $fillable = ['name', 'email', 'password', 'role_id'];
        public $timestamps = true;
        
        protected $hidden = ['password', 'remember_token'];
    };
    
    $adminRole = $roleModel->where('name', 'admin')->first();
    
    if ($adminRole) {
        echo "Inserting default admin user...\n";
        $userModel->firstOrCreate(
            ['email' => 'admin@simpede.id'],
            [
                'name' => 'Administrator',
                'password' => password_hash('Password', PASSWORD_DEFAULT),
                'role_id' => $adminRole->id,
            ]
        );
    }
    
    echo "Database setup completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}