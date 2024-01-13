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

## Using livewire components.

    Note: livewire is just like a blade component but with some added benefits.

1. Make a livewire component in the terminal using the following command
   note: a class and view will be generated.

```
php artisan make:livewire CreatePoll
```

2. To use the component either use a @livewire('create-poll') directive with the view name.

3. In the CreatePoll class pass a public property and that public property can be seen updated live in a php varible output using
   the wire:mode.live="property name" in the input tag.

4. Adding further public properties in the class fn and then implmenting it with livewire actions on the view.

5. Creating a public fuction mount to intialize the public properties.
   Note: This only runs once and does not run again with subsequent re-renders.

## Implementing Poll options.

1. Create a public function in the class that can be later called in using wire actions to add new poll.

2. To add a new element to an existing arry we use

```
$this->options[] = '';
```

Note: The $options property must be defined before hand and must be initialized with an empty string like [''] either manually or using mount fn.

3. Using a foreach loop we can iterate over each element while accounting for any new element added through the addOption action

4. Next implemnt a remove button and generate a function for the button action logic (using the $index param)

```
unset($this->options[$index]);
$this->options = array_values($this->options); // this is to make sure the array does not retain any gaps.
```

5. When using params in actions like $index inlcude them in using php

```
wire:click.prevent="removeOption({{$index}})"
```

## Creating || Saving poll to the backend (mysql-db).

1. Adding a submit button and then making another action for poll-component to save data on the database.
   Note: Don't forget to use .prevent on the form when listening for submit.

2. Before using the mass-asignment feature in the createPoll fn, we need to first define the $fillables in the poll model.

```
protected $fillable = ['title']     // for the poll model
protected $fillable = ['name']      // for the option model
```

3. Poll can be saved using createPoll logic as follows: (for adding poll option we will use loop)

```
$poll = Poll::create([
    'title' => $this->title,        // $this->title refers to the $title in the component
]);

foreach($this->options as $optionName) {
    $poll->options()->create(['name' => $optionName]);      // poll model has the options() relation which gives us create
}

$this->reset(['title', 'options']);     // this refrehes the properties on the page after saving to db
```

Note: Keep note of adding the correct namespaces for the model.
