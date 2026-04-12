@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'bg-white/40 backdrop-blur-md border border-onyx/5 p-8 bespoke-card hover:shadow-premium transition-all duration-700 group']) }}>
    @if($title || $description)
    <div class="mb-8 border-b border-onyx/5 pb-6">
        @if($title)
            <h3 class="font-serif text-2xl text-onyx leading-tight mb-2">{{ $title }}</h3>
        @endif
        @if($description)
            <p class="text-[10px] font-bold tracking-ultra uppercase text-onyx/40">{{ $description }}</p>
        @endif
    </div>
    @endif
    
    <div>
        {{ $slot }}
    </div>
</div>