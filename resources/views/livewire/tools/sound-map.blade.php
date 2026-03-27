<div class="h-screen w-full bg-[#0d1117] flex relative">
    <!-- Globe Container -->
    <div id="globeViz" class="w-full h-full"></div>

    <!-- UI Overlay -->
    <div class="absolute top-24 left-8 pointer-events-none">
        <h1 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter loading-none mb-2">
            GLOBAL SOUND MAP
        </h1>
        <p class="text-white/50 text-sm font-bold tracking-widest uppercase">Explore Music Origins</p>
    </div>

    <!-- Info Panel (Shows on hover) -->
    <div id="infoPanel" class="absolute bottom-12 right-12 w-80 bg-black/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 transform translate-x-[120%] transition-transform duration-300 pointer-events-none">
        <div class="flex items-center gap-4 mb-4">
            <img id="panelImage" src="" class="w-16 h-16 rounded-xl object-cover bg-white/10">
            <div>
                <h3 id="panelTitle" class="text-white font-black text-xl uppercase leading-tight">Artist Name</h3>
                <p id="panelSubtitle" class="text-blue-400 text-xs font-bold uppercase tracking-widest">Genre • Year</p>
            </div>
        </div>
        <p class="text-white/60 text-sm leading-relaxed mb-4">Originating from <span id="panelLocation" class="text-white font-bold">Location</span>.</p>
        <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 w-2/3"></div>
        </div>
    </div>

    <!-- Globe GL Script -->
    <script src="//unpkg.com/globe.gl" defer></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Wait for script to load or use defer
            const initGlobe = () => {
                if (typeof Globe === 'undefined') {
                    setTimeout(initGlobe, 500);
                    return;
                }

                const points = @js($points);
                const elem = document.getElementById('globeViz');
                const panel = document.getElementById('infoPanel');

                const world = Globe()
                    (elem)
                    .globeImageUrl('//unpkg.com/three-globe/example/img/earth-dark.jpg')
                    .bumpImageUrl('//unpkg.com/three-globe/example/img/earth-topology.png')
                    .backgroundImageUrl('//unpkg.com/three-globe/example/img/night-sky.png')
                    .pointsData(points)
                    .pointAltitude(0.12)
                    .pointColor('color')
                    .pointRadius(0.5)
                    .pointsMerge(true)
                    .pointResolution(2)
                    .onPointHover(point => {
                        if (point) {
                            panel.style.transform = 'translateX(0)';
                            document.getElementById('panelTitle').innerText = point.name;
                            document.getElementById('panelImage').src = point.avatar || 'https://via.placeholder.com/150';
                            document.getElementById('panelSubtitle').innerText = point.genre || 'Artist';
                            document.getElementById('panelLocation').innerText = `${point.lat.toFixed(2)}, ${point.lng.toFixed(2)}`;
                            elem.style.cursor = 'pointer';
                        } else {
                            panel.style.transform = 'translateX(120%)';
                            elem.style.cursor = 'default';
                        }
                    })
                    .onPointClick(point => {
                        if(point.url) window.location.href = point.url;
                    });

                // Auto-rotate
                world.controls().autoRotate = true;
                world.controls().autoRotateSpeed = 0.5;
            };
            
            initGlobe();
        });
    </script>
</div>
