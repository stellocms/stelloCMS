<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', cms_name()); ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Forms Plugin -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            plugins: [
                require('@tailwindcss/forms'),
            ],
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/dist/outline/index.min.js"></script>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?php echo $__env->yieldContent('description', cms_description()); ?>">
    <meta name="author" content="<?php echo e(cms_name()); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo e(url('/')); ?>" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        <?php echo e(cms_name()); ?>

                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <?php if(isset($headerMenus)): ?>
                        <?php $__currentLoopData = $headerMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(isset($menu->route) && Route::has($menu->route) ? route($menu->route) : ($menu->url ?? '#')); ?>"
                               class="text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <?php if($menu->icon): ?>
                                    <i class="<?php echo e($menu->icon); ?> mr-1"></i>
                                <?php endif; ?>
                                <?php echo e($menu->title); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </nav>

                <!-- Dark Mode Toggle -->
                <div class="flex items-center">
                    <button @click="darkMode = !darkMode"
                            class="p-2 rounded-full text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span x-show="!darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                        </span>
                        <span x-show="darkMode" style="display:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                        </span>
                    </button>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden ml-4 p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" 
             class="md:hidden bg-white dark:bg-gray-800 shadow-lg"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <?php if(isset($headerMenus)): ?>
                    <?php $__currentLoopData = $headerMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(isset($menu->route) && Route::has($menu->route) ? route($menu->route) : ($menu->url ?? '#')); ?>"
                           class="text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                            <?php if($menu->icon): ?>
                                <i class="<?php echo e($menu->icon); ?> mr-2"></i>
                            <?php endif; ?>
                            <?php echo e($menu->title); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Widgets Header -->
            <?php if(isset($headerWidgets) && $headerWidgets->count() > 0): ?>
                <div class="mb-8">
                    <?php $__currentLoopData = $headerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <?php if($widget->type === 'html'): ?>
                                <div><?php echo $widget->content; ?></div>
                            <?php elseif($widget->type === 'text'): ?>
                                <div class="text-gray-700 dark:text-gray-300"><?php echo e($widget->content); ?></div>
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
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- Widgets Home -->
            <?php if(isset($homeWidgets) && $homeWidgets->count() > 0): ?>
                <div class="mt-12">
                    <?php $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 transition-all hover:shadow-lg">
                            <?php if($widget->type === 'html'): ?>
                                <div><?php echo $widget->content; ?></div>
                            <?php elseif($widget->type === 'text'): ?>
                                <div class="text-gray-700 dark:text-gray-300"><?php echo e($widget->content); ?></div>
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
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Site Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4"><?php echo e(cms_name()); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        <?php echo e(cms_description()); ?>

                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.129 22 16.99 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Widgets Footer -->
                <?php if(isset($footerWidgets)): ?>
                    <?php $__currentLoopData = $footerWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-span-1 md:col-span-2">
                            <?php if($widget->type === 'html'): ?>
                                <div><?php echo $widget->content; ?></div>
                            <?php elseif($widget->type === 'text'): ?>
                                <div class="text-gray-700 dark:text-gray-300"><?php echo e($widget->content); ?></div>
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
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php elseif(isset($homeWidgets)): ?>
                    <!-- Jika tidak ada footer widgets, tampilkan home widgets di footer -->
                    <?php $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-span-1 md:col-span-2">
                            <?php if($widget->type === 'html'): ?>
                                <div><?php echo $widget->content; ?></div>
                            <?php elseif($widget->type === 'text'): ?>
                                <div class="text-gray-700 dark:text-gray-300"><?php echo e($widget->content); ?></div>
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
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <!-- Tautan tambahan footer -->
                </div>
                <p class="mt-8 text-center text-base text-gray-500 dark:text-gray-400 md:mt-0 md:order-1">
                    &copy; <?php echo e(date('Y')); ?> <?php echo e(cms_name()); ?>. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>
</body>
</html><?php /**PATH D:\htdocs\stelloCMS\app\Themes/frontend/standard/layouts/app.blade.php ENDPATH**/ ?>