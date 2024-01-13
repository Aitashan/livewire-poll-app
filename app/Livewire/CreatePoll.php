<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePoll extends Component
{
    // #[Validate]
    public $title;

    // #[Validate]
    public $options = ['first'];

    protected $rules = [
        'title'=> 'required|min:3|max:255',
        'options'=> 'required|array|min:2|max:10',    // how to show this validaiton in real-time 
        'options.*' => 'required|min:2|max:255'
    ];

    protected $messages = [
        'options.*.required' => 'The option cannot be empty.',
        'options.min' => 'There must be atleast two options',
        'options.*' => 'The option must be valid length.'
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        if (count($this->options) <= 9)  // instead of hardcoding 9 how can i make use of validation check
        {
            $this->options[] = '';
        }
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate();

        Poll::create([
            'title'=> $this->title,
            ])->options()->createMany(
                collect($this->options)->map(fn ($option) => ['name' => $option])->all()
            );

        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        $this->reset(['title','options']);

        $this->dispatch('pollCreated');
    }

    

//     public function mount()
//     {

//     }
}
