# A Rough Representation of the Code-Along.

## Creating the Project.

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

## Creating Models and Migrations.

1. setting db -> [ 'name', 'port' ] in the .env file

2. To create the table and default migrations use

```terminal
php artisan migrate
```

3. Creating models (Poll, Vote and Option) -m flag is used to create migrations

```
php artisan make:model Poll -m
php artisan make:model Vote -m
php artisan make:model Option -m
```

4.  Configure relationships between all the models:
    add a options function to the poll model (HasMany) as a poll can have many options
    add a poll function to the option model (BelongsTo) as each option must be linked to a poll
    add a votes fn -> option Model (HasMany) as each option can have multiple votes
    add a option fn -> vote Model (BelongsTo) as each vote is linked to a single option

5.  Next we need to fill out the migrations with the required column types, add foreign ids and lastly refresh the db.
    note: when creating migrations keep note of the order and adjust accordingly to avoid any key associaing errors when the foreign key table is called earlier then the primary key table it was reflecting to. Also check for unwanted namespace or use pathway explicitly for the classes.
