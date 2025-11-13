<?php $__env->startSection('title', 'Beranda - ' . cms_name()); ?>
<?php $__env->startSection('description', 'Platform CMS modern dan mudah digunakan untuk mengelola konten website Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <section class="py-12 md:py-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Text -->
                <div class="order-2 lg:order-1">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                            Platform CMS
                        </span>
                        <br>
                        <span class="text-gray-900 dark:text-white">Modern & Mudah Digunakan</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 dark:text-gray-300 max-w-3xl">
                        Buat dan kelola website Anda dengan antarmuka yang intuitif dan fleksibilitas yang tinggi melalui sistem stelloCMS kami yang dirancang untuk kemudahan penggunaan.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo e(route('panel.dashboard')); ?>" class="btn-gradient text-white font-semibold py-3 px-8 rounded-lg text-center shadow-lg hover:shadow-xl transition-shadow">
                            Dashboard
                        </a>
                        <a href="#" class="bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 font-semibold py-3 px-8 rounded-lg border border-indigo-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 text-center shadow hover:shadow-md">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                
                <!-- Hero Image/Graphic -->
                <div class="order-1 lg:order-2 relative">
                    <!-- Background elements -->
                    <div class="absolute -top-4 -left-4 w-64 h-64 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full mix-blend-multiply filter blur-xl opacity-30 dark:opacity-20 animate-pulse"></div>
                    <div class="absolute -bottom-8 -right-8 w-64 h-64 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 dark:opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
                    
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 max-w-md mx-auto">
                        <div class="aspect-video bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-900 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <div class="mx-auto flex justify-center">
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Platform CMS</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Sistem yang fleksibel dan mudah digunakan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Sistem stelloCMS menawarkan berbagai fitur yang memudahkan Anda dalam mengelola konten website
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="w-12 h-12 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Manajemen Konten</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Buat dan kelola berbagai jenis konten dengan antarmuka yang mudah digunakan dan editor yang canggih.
                    </p>
                </div>
                
                <!-- Feature Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c.897.417 1.598.97 1.598 1.723a4.5 4.5 0 01-.293 1.744M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm6.75 3a.75.75 0 00-1.5 0v.008a.75.75 0 001.5 0v-.008z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15.75a3 3 0 01-3-3V12a3 3 0 013-3v-.75a3 3 0 013 3v.75a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Tema dan Plugin</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Gunakan sistem tema dan plugin yang modular untuk meningkatkan fungsionalitas website Anda.
                    </p>
                </div>
                
                <!-- Feature Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 card-hover border border-gray-100 dark:border-gray-700">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Keamanan Tinggi</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Sistem keamanan terbaru untuk melindungi data dan akses ke sistem Anda dengan role-based access control.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Widgets Home Section -->
    <?php if(isset($homeWidgets) && $homeWidgets->count() > 0): ?>
    <section class="py-16 bg-gray-50 dark:bg-gray-900/30 rounded-2xl my-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Konten Tambahan</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Widget dinamis yang menampilkan informasi terbaru dari sistem
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-all hover:shadow-lg border border-gray-100 dark:border-gray-700 card-hover">
                    <div class="flex items-start mb-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1-8v8a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-10 0h10M7 8v8" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e($widget->name); ?></h3>
                            <span class="inline-block mt-1 text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <?php echo e(ucfirst($widget->type)); ?>

                            </span>
                        </div>
                    </div>
                    
                    <?php if($widget->type === 'html'): ?>
                        <div class="prose prose-indigo dark:prose-invert max-w-none text-gray-700 dark:text-gray-300"><?php echo $widget->content; ?></div>
                    <?php elseif($widget->type === 'text'): ?>
                        <div class="text-gray-700 dark:text-gray-300"><?php echo e(Str::limit(strip_tags($widget->content ?? ''), 150, '...')); ?></div>
                    <?php elseif($widget->type === 'plugin' && $widget->plugin_name): ?>
                        <?php
                            $pluginClass = "App\\Plugins\\" . $widget->plugin_name . "\\Controllers\\" . $widget->plugin_name . "Controller";
                            if (class_exists($pluginClass)) {
                                $controller = new $pluginClass();
                                if (method_exists($controller, 'getWidgetContent')) {
                                    echo $controller->getWidgetContent();
                                } elseif (method_exists($controller, 'get' . $widget->plugin_name . 'Widget')) {
                                    $method = 'get' . $widget->plugin_name . 'Widget';
                                    echo $controller->$method();
                                }
                            }
                        ?>
                    <?php endif; ?>
                    
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Urutan: <?php echo e($widget->order); ?>

                        </span>
                        <span class="inline-block text-xs px-2 py-1 rounded-full 
                            <?php echo e($widget->status === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'); ?>">
                            <?php echo e($widget->status); ?>

                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">Siap Memulai?</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto">
                Bangun website Anda dengan platform yang handal dan mudah digunakan
            </p>
            <a href="<?php echo e(route('panel.dashboard')); ?>" class="btn-gradient text-white font-bold py-3 px-8 rounded-lg inline-block shadow-lg hover:shadow-xl transition-all">
                Akses Dashboard
            </a>
        </div>
    </section>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
    
    .animate-pulse {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }
    
    .prose {
        max-width: none;
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-gradient:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.frontend.standard::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/frontend/standard/home/index.blade.php ENDPATH**/ ?>