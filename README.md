# A Rough Representation of the Code-Along.

### Creating the Project.

1. using the command in the terminal
   composer create-project --prefer-dist laravel/laravel livewire-poll

2. As we are using the livewire library we need to first go into the project folder then add the livewire library using
   composer livewire/livewire

3. Adding the base template code provided in the instructors github to app.blade.php (replacing the welcome file).

4. To use the live wire library 2 directives: @livewireStyles(in the head) and @livewireScripts(at the bottom in the body) are added to the app layout html

5. Setting up a temp route in web.php
