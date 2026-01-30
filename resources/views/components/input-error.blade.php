@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[9px] font-black text-red-500 uppercase tracking-widest space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <span class="w-1 h-1 rounded-full bg-red-500"></span>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
