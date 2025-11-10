    /**
     * Create menu for a plugin
     */
    protected function createPluginMenu($pluginName)
    {
        // Remove existing menu if any
        $this->removePluginMenu($pluginName);

        // Create admin menu
        $adminMenu = new \App\Models\Menu([
            'name' => strtolower($pluginName),
            'title' => $this->getPluginTitle($pluginName),
            'route' => $this->getPluginRoute($pluginName),
            'icon' => $this->getPluginIcon($pluginName),
            'plugin_name' => $pluginName,
            'type' => 'admin',
            'position' => 'sidebar', // Default to sidebar for admin
            'is_active' => true,
            'roles' => ['admin', 'kepala-desa', 'sekdes'] // Default roles for plugin management
        ]);

        $adminMenu->save();

        // For specific plugins, also create frontend menu in header
        if ($this->shouldCreateFrontendMenu($pluginName)) {
            $frontendMenu = new \App\Models\Menu([
                'name' => strtolower($pluginName) . '_frontend',
                'title' => $this->getPluginTitle($pluginName),
                'route' => $this->getPluginRoute($pluginName),
                'icon' => $this->getPluginIcon($pluginName),
                'plugin_name' => $pluginName,
                'type' => 'frontend',
                'position' => 'header',
                'is_active' => true,
                'roles' => [] // No role restrictions for frontend
            ]);

            $frontendMenu->save();
        }
    }

    /**
     * Remove menu for a plugin
     */
    protected function removePluginMenu($pluginName)
    {
        \App\Models\Menu::where('plugin_name', $pluginName)->delete();
    }

    /**
     * Determine if a plugin should have a frontend menu
     */
    protected function shouldCreateFrontendMenu($pluginName)
    {
        // Define which plugins should have frontend menu
        $frontendPlugins = ['Berita', 'ContohPlugin'];
        
        return in_array($pluginName, $frontendPlugins);
    }