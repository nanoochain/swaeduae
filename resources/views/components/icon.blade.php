@props(['name', 'class' => 'w-6 h-6'])

<img src="{{ asset('icons/' . $name) }}" alt="{{ $name }}" class="{{ $class }}">
