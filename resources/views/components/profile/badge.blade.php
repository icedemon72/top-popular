@props(['role'])

@php 
    $baseClass = 'p-1 rounded-xl text-xs uppercase font-bold text-main ';
    $roleClass = 'bg-green-500 dark:bg-green-500';

    if($role == 'moderator') {
        $roleClass = 'bg-orange-500';
    }
    else if ($role == 'user') {
        $roleClass = 'bg-gray-500';
    }
        
@endphp

<span {{ $attributes->merge(['class' => $baseClass.$roleClass]) }}>
	{{ $role }}		
</span>
