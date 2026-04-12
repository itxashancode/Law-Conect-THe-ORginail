@props(['class' => ''])

<div x-data="{ 
        x: 0, 
        y: 0,
        active: false,
        init() {
            this.$el.addEventListener('mousemove', (e) => {
                const rect = this.$el.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                this.x = (e.clientX - centerX) * 0.4;
                this.y = (e.clientY - centerY) * 0.4;
            });
            this.$el.addEventListener('mouseleave', () => {
                this.x = 0;
                this.y = 0;
            });
        }
     }"
     class="inline-block transition-transform duration-300 ease-out {{ $class }}"
     :style="`transform: translate(${x}px, ${y}px)`">
    {{ $slot }}
</div>
