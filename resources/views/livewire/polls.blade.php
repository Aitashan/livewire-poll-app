<div>
    @forelse ($polls as $poll)
        <div class="mb-4">
            <div>
                <h3 class="mb-1 text-xl">
                    {{ $poll->title }}
                </h3>
                <button class="mb-3 btn justify-self-end" wire:click.prevent="removePoll({{ $poll }})"
                    wire:confirm="Are you sure?">Remove
                    Poll</button>
            </div>
            @foreach ($poll->options as $option)
                <div class="mb-2">
                    <button class="btn" wire:click="vote({{ $option->id }})">Vote</button>
                    {{ $option->name }} ({{ $option->votes->count() }})
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500">
            No Polls Available.
        </div>
    @endforelse
</div>
