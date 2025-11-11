# stelloCMS Documentation

## About stelloCMS

stelloCMS is a Laravel-based Content Management System (CMS) designed to simplify website content management. The system comes with dynamic themes, modular plugins, and flexible user management features.

## Key Features

### 1. Dynamic Theme System
- Automatically detects themes from folders
- Support for separate admin and frontend themes
- Easy to add new themes with simple folder structure

### 2. Modular Plugin System
- Plugins can be dynamically installed, activated, and removed
- Each plugin can have its own database, migrations, and routing
- Automatic menu system for installed plugins

### 3. User Management and Access Control
- Various user levels (admin, village head, secretary, etc.)
- Role-based access control (RBAC) system
- Menu-based access management

### 4. Administration Interface
- Informative dashboard
- Intuitive theme and plugin management
- Dynamic menu system

## Installation

### System Requirements
- PHP >= 8.2
- MySQL >= 5.7 or MariaDB >= 10.2
- Composer
- Node.js and NPM (optional)

### Installation Steps
1. Clone the stelloCMS repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Configure database in `.env` file
5. Run `php artisan key:generate`
6. Run `php artisan migrate --seed`
7. Access the application through your browser

## Configuration

### Basic Configuration
- `ADMIN_THEME`: Theme used for administration panel
- `FRONTEND_THEME`: Theme used for public view
- `CMS_NAME`: CMS name displayed
- `CMS_DESCRIPTION`: CMS description

### Database Configuration
- `DB_CONNECTION`: Database connection type
- `DB_HOST`: Database host
- `DB_PORT`: Database port
- `DB_DATABASE`: Database name
- `DB_USERNAME`: Database username
- `DB_PASSWORD`: Database password

## Theme System

### Theme Structure
Each theme must have a basic structure:
```
/themes/
├── admin/
│   └── {theme_name}/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       └── theme.json
└── frontend/
    └── {theme_name}/
        ├── layouts/
        │   └── app.blade.php
        └── theme.json
```

### Creating New Themes
1. Create theme folder in `/themes/admin/` or `/themes/frontend/`
2. Add `theme.json` file with theme information
3. Create required view structure
4. Theme will be automatically detected

## Plugin System

### Plugin Structure
Each plugin must have a basic structure:
```
/Plugins/
└── {plugin_name}/
    ├── Controllers/
    ├── Models/
    ├── Views/
    ├── Database/
    │   ├── Migrations/
    │   └── Seeders/
    ├── routes.php
    ├── plugin.json
    └── helpers.php (optional)
```

### Creating New Plugins
1. Create plugin folder in `/app/Plugins/`
2. Add `plugin.json` file with plugin information
3. Create required controllers, models, and views
4. Add database migrations if needed
5. Plugin will be automatically detected

### Installing Plugins
1. Access administration panel
2. Open "Plugin" menu
3. Click "Install" button on desired plugin
4. Plugin will be installed and activated automatically

### Removing Plugins
1. Access administration panel
2. Open "Plugin" menu
3. Click "Remove" button on desired plugin
4. Plugin will be removed from system (data can be preserved)

## Development

### Creating Themes
To create a new theme:
1. Follow the defined theme structure
2. Use `view_theme()` helper for view rendering
3. Ensure `theme.json` contains complete information

### Creating Plugins
To create a new plugin:
1. Follow the defined plugin structure and naming conventions (use PascalCase for plugin name)
2. Use appropriate namespace (`App\Plugins\{PluginName}\...`)
3. Add database migrations if needed
4. Optionally, add `install.php` with `{PluginName}Installer` class for dynamic table management
5. Use `view_theme()` helper for plugin view rendering

## Troubleshooting

### Common Errors
- **Class not found**: Ensure namespace and folder structure are correct
- **View not found**: Ensure views use correct namespace
- **Database error**: Check database connection and permissions

### Maintenance
- Run `php artisan config:clear` to clear configuration cache
- Run `php artisan view:clear` to clear view cache
- Run `php artisan route:clear` to clear route cache

## License

stelloCMS is licensed under the MIT license.

## Contribution

We welcome contributions from the community. To contribute:
1. Fork the repository
2. Create a new feature branch
3. Commit changes
4. Push to branch
5. Create pull request

## Contact

For questions and support, please contact the stelloCMS development team.