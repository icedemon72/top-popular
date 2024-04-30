@props(['user'])

@php
    $socials = [
        'Github' => $user->github,
        'Youtube' => $user->youtube,
        'X' => $user->x,
        'Instagram' => $user->instagram,
        'Facebook' => $user->facebook,
    ];
@endphp

<div>
    <x-profile.info-field class="w-full" title="{{ __('Description') }}" :text="$user->desc" />
    <div class="grid grid-cols-3 gap-2 mt-2">
        <x-profile.info-field class="col-span-3 md:col-span-1" title="{{ __('Location') }}" :text="$user->location" />
        <x-profile.info-field class="col-span-3 md:col-span-1" title="{{ __('Timezone') }}" :text="$user->timezone" />
        <x-profile.info-field class="col-span-3 md:col-span-1" title="{{ __('Ocupation') }}" :text="$user->ocupation" />
    </div>

    <div class="grid grid-cols-4 lg:grid-cols-3 gap-2 mt-2">
        @foreach ($socials as $key => $social)
            @if(strlen($social))
                <div class="col-span-2 lg:col-span-1">
                    <p class="text-muted text-sm font-semibold">{{ __($key) }}</p>
                    <div class="flex items-center">
                        <a class="flex items-center gap-2 py-1 rounded-lg hover:bg-card hover:underline" href="{{ $user->$social }}">
                            <span class="text-sm">{{ $social }}</span>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <x-profile.info-field class="w-full mt-2" title="{{ __('Website') }}" :text="$user->website" :link="true" />
</div>