# stelloCMS Widget Integration Documentation

## Overview
This document provides comprehensive documentation about the widget integration system in stelloCMS, including:
- Widget management and display functionality
- Plugin architecture for custom widgets 
- Frontend theme integration
- Troubleshooting guides for common issues

## Table of Contents
1. [Introduction](#introduction)
2. [Widget Management System](#widget-management-system)
3. [Plugin Architecture](#plugin-architecture)
4. [Frontend Theme Integration](#frontend-theme-integration)
5. [Troubleshooting](#troubleshooting)
6. [Developer Guide](#developer-guide)

## Introduction
stelloCMS is a flexible content management system that supports extensive customization through plugins and widgets. Widgets provide dynamic content modules that can be positioned in different areas of the website (header, sidebar, footer, content area, etc.).

## Widget Management System

### Core Components
The widget system is composed of several key components:

1. **Widget Model (App\Models\Widget)**
   - Represents individual widget entities
   - Defines properties like name, type, position, status, content, etc.
   - Includes relationships to users and categories

2. **Widget Controller (App\Http\Controllers\WidgetController)**
   - Handles CRUD operations for widgets
   - Manages widget positioning and ordering
   - Provides AJAX endpoints for drag-and-drop functionality

3. **Widget Views**
   - Located in `app/Themes/admin/adminlte/widgets/`
   - Includes index, create, edit, and show views
   - Implements responsive UI with Tailwind CSS

### Widget Types
- **HTML**: Raw HTML content
- **Text**: Plain text with basic formatting
- **Plugin**: Dynamic content from integrated plugins
- **Custom**: Specialized content types based on user needs

### Widget Positions
Widgets can be positioned in various areas:
- Header
- Sidebar Left
- Sidebar Right
- Footer
- Home
- Content area
- Custom positions defined by theme

## Plugin Architecture

### Creating Widget Plugins
Widget plugins can be created to provide dynamic content:

```php
// Example: Custom widget plugin structure
App\
  Plugins\
    CustomWidget\
      Controllers\
        CustomWidgetController.php
      Models\
        CustomWidget.php
      Views\
        widget\
          custom-display.blade.php
```

### Integration Points
- Hook into widget rendering system
- Leverage CMS data and services
- Integrate with authentication and authorization
- Support for AJAX and dynamic updates

## Frontend Theme Integration

### Theme Structure
```
app/
  Themes/
    frontend/
      standard/
        layouts/
          app.blade.php
        widgets/
          index.blade.php
        home/
          index.blade.php
```

### Widget Display in Frontend
- Widget positions defined in theme layouts
- AJAX-powered drag-and-drop interface
- Responsive design supporting all device sizes
- Consistent styling with Tailwind CSS

### View Composer Integration
- Automatic widget data injection to views
- Performance optimized widget loading
- Support for different widget types and caching strategies

## Troubleshooting

### Common Issues and Solutions

#### 1. "Cannot end a section without first starting one"
**Issue**: Blade template error when displaying pages
**Cause**: Incorrect blade syntax in widget templates
**Solution**: 
- Use explicit `@section('name')` and `@endsection` blocks
- Avoid using `@section('name', 'value')` shorthand format
- Validate all template files have balanced opening/closing tags

#### 2. "Target class [App\Http\Controllers\WidgetService] does not exist"  
**Issue**: Service resolution error
**Cause**: Incorrect namespace usage
**Solution**: Use correct namespace `App\Services\WidgetService`

#### 3. Widget drag-and-drop not working between positions
**Issue**: Widgets can't be moved between different positions
**Cause**: Inconsistent DOM structure between widget containers
**Solution**: Ensure all widget containers have identical HTML structure

#### 4. "Uncaught ReferenceError: $ is not defined"
**Issue**: jQuery not loaded before JavaScript execution
**Cause**: JavaScript placed before jQuery library load
**Solution**: Move JavaScript to scripts section after jQuery loads

### Debugging Steps
1. Clear cache: `php artisan cache:clear`
2. Clear view cache: `php artisan view:clear`
3. Check route definitions: `php artisan route:list`
4. Verify database connectivity and widget records
5. Check browser console for JavaScript errors

## Developer Guide

### Adding Custom Widget Types
To add a new widget type:

1. Update Widget model with new type constant
2. Add validation rules in WidgetController
3. Create dedicated view for the new type
4. Update service layer to handle new type
5. Test drag-and-drop functionality

### Widget Position Management
Positions are managed through:
- `position` field in Widget model
- Configuration in theme files
- Dynamic loading based on active widgets

### Best Practices
- Use Tailwind CSS for consistent styling
- Implement responsive design patterns
- Follow Laravel Blade template conventions
- Test cross-browser compatibility
- Optimize for performance with lazy loading
- Use appropriate caching strategies
- Maintain accessibility standards

### Security Considerations
- Sanitize user-inputted content
- Use CSRF tokens for forms
- Validate and sanitize widget inputs
- Prevent XSS through proper escaping
- Implement proper access controls

## Future Enhancements
- Advanced widget caching mechanisms
- Drag-and-drop preview functionality  
- Widget template customization options
- Enhanced accessibility features
- Performance optimization techniques

## Conclusion
The widget system in stelloCMS provides a flexible and powerful way to manage dynamic content across your website with customizable positioning and plugin support.

---
Document last updated: {{DATE}}