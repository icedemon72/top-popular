@php
    $rules = [
        __('Always Be Civil') => __('Nothing sabotages a healthy conversation like rudeness'),
        __('Keep It Tidy') =>  __('Make the effort to put things in the right place, so that we can spend more time discussing and less cleaning up.'),
        __('Post Only Your Own Stuff') =>  __('You may not post anything digital that belongs to someone else without permission. You may not post descriptions of, links to, or methods for stealing someone\'s intellectual property (software, video, audio, images), or for breaking any other law.'),
        __('Be Agreeable, Even When You Disagree') =>  __('You may wish to respond to something by disagreeing with it. That\'s fine. But, remember to criticize ideas, not people.'),
        __('Improve the Discussion') =>  __('Help us make this a great place for discussion by always working to improve the discussion in some way, however small. If you are not sure your post adds to the conversation, think over what you want to say and try again later.'),
        __('Remember to Have Fun') =>  __(':)')
    ];
@endphp

<ul {{ $attributes->merge(['class' => 'list-decimal p-2']) }}>
    @foreach($rules as $rule => $desc)
    <li class = "text-muted font-bold cursor-default py-1"  
        x-data="{ open: false }"
        x-on:click.outside="open = false" 
        x-on:click="open = !open"
    >
        <div class="flex justify-between items-center">
            <span class="flex-1">
                {{ $rule }}
            </span>
            <div class="cursor-pointer">
                <x-lucide-chevron-down x-cloak x-show="!open"/>
                <x-lucide-chevron-up x-cloak x-show="open"/>
            </div>
        </div>
        <span class="font-normal block" x-cloak x-show="open" x-collapse>
            {{ $desc }}
        </span>
    </li>
    @endforeach
</ul>