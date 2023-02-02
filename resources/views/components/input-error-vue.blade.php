@props(['property', 'object'])

<div v-if="{{ $object }}.errors.{{ $property }}" {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
    <ul>
        <li v-for="error in {{ $object }}.errors.{{ $property }}">
            @{{  error }}
        </li>
    </ul>
</div>