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

## Side-quest (Re-factoring the createPoll fn).

```
Poll::create([
            'title'=> $this->title,
            ])->options()->createMany(
                collect($this->options)->map(fn ($option) => ['name' => $option])->all()
            );
```

Instead of using foreach, we can do this the more laravel way. It is always best to minimize the use of variables.

1. We can use the options() relation directly on the create model and then chain it with createMany.

2. The Inside createMany we can use collect to make a collection of all the options and then return them with ->all().

## Seting up Validation using liveWire.

1. First we need to define rules array in the compoent under the pre-set properties. Note to validate the inner parts of an array or collection we use "array.\*" notation

```
protected $rules = [
    'title' => 'required|min:3|max:255',
    'options' => 'required|array|min:2|max:10',
    'options.*' => 'required|min:1|max:255
];
```

2. Next we just add validate method to the function that handles/submmits the form.

```
$this->validate();
```

3. To visually display invalid requests we can add @error directive in the blade view.

```
@error('options.{index}')
        <div class="text-red-500">{{ $message }}</div>
@enderror
```

4. For customzing the error messages we need to define another varible in the component.

```
protected $messages = [
    'options.*.required' => 'The option cannot be empty',
];
```

5. To show real-time-validation on the page an updated fn can be added to the component.

```
public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
```

## Implementing Poll page and Votes.

1. Make new livewire component

```
php artisan make:livewire Polls
```

2. We can all the polls using Poll model along "with" method to get options and its respective votes.

```
Poll::with('options.vote')->latest()->get();
```

3. add the livewire directive to the app layout with the new component name.

4. laslty we index all the polls using forelse and foreach loops on the new poll.blade view.

## Livewire Events.

This typicaly very easy all you need to do is add $this->dispatch('eventName') and then add #[On('eventName')] before the function you want updated in real-time.

## Adding remove poll btn.

Add btn in new poll blade view and make a remove function using $poll which is already being iterated over in the blade file as a param to the new polls controller.

## Implementing votes.

This is also done in a similar fashion where first we get the option by adding the findOrFail method to the option model then by simply passing in the id that was iterated over in the for loop we can pass it over along with a votes method to get that specific vote and end with create.

This is just a counter for how many times the option is clicked so hitting create on the vote model with the specfic option id adds a timestamp to the table where finally the count method on the blade file adds all the similar ids.

Note: This can also be done using route model binding.
