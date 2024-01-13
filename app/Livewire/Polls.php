<?php

namespace App\Livewire;

use App\Models\Poll;
use App\Models\Option;
use Livewire\Component;
use Livewire\Attributes\On;

class Polls extends Component
{
    #[On('pollCreated')]
    public function render()
    {
        $polls = Poll::with('options.votes')->latest()->get();

        return view('livewire.polls', ['polls' => $polls]);
    }

    public function removePoll(Poll $poll)
    {
        $poll->options()->delete();
        $poll->delete();
    }

    public function vote (Option $option)
    {
        $option->votes()->create();
    }
}
