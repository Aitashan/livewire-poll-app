# A Rough Representation of the Code-Along.

### Creating the Project.

1. using the command in the terminal

```terminal
composer create-project --prefer-dist laravel/laravel livewire-poll
```

2. As we are using the livewire library we need to first go into the project folder then add the livewire library using

```terminal
composer livewire/livewire
```

3. Adding the base template code provided in the instructors github to app.blade.php (replacing the welcome file).

4. To use the live wire library 2 directives: @livewireStyles and @livewireScriptsare added to the app.layout

```html
<head>
    @livewireStyles
    <body>
        @livewireScripts // this is added at the end after all the content
    </body>
</head>
```

5. Setting up a temp route in web.php

### Creating Models and Migrations.

1. setting db -> [ 'name', 'port, ] in the .env file

2. To create the table and default migrations use

```terminal
php artisan migrate
```
