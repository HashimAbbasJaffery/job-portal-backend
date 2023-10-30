@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li style="color: #111433">{{ $message }}</li>
        @endforeach
    </ul>
@endif
