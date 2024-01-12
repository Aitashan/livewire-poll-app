<div>
    <form>

        <label>Poll Title</label>

        <input type="text" wire:model.live="title" />

        Current title: {{ $title }}

        <div class="mt-4 mb-4 flex gap-x-2">
            <input type="text" />

            <button class="btn" wire:click.prevent="addOption">Add Option</button>
        </div>

        <div class="mt-1">
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    {{ $index }} - {{ $option }}
                </div>
            @endforeach
        </div>

    </form>
</div>
