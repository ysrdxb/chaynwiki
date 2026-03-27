@props(['currentKey' => null, 'compatibleKeys' => []])

@php
    $keys = range(1, 12);
    // 12 sectors, 30 deg each. 
    // 12B (E Maj) is usually at Top (let's place it at -90 deg? or 0 deg?)
    // Let's assume 12 is at 12 o'clock.
    
    // Radius values (0-50 based on viewBox 100x100)
    $rOuter = 48;
    $rMid = 35;
    $rInner = 22;
    $cx = 50;
    $cy = 50;

    function getEx($angle, $r, $cx, $cy) {
        $rad = deg2rad($angle - 90); // -90 to start at top
        return [
            'x' => $cx + $r * cos($rad),
            'y' => $cy + $r * sin($rad)
        ];
    }

    function describeArc($startAngle, $endAngle, $innerR, $outerR, $cx, $cy) {
        $startOuter = getEx($startAngle, $outerR, $cx, $cy);
        $endOuter = getEx($endAngle, $outerR, $cx, $cy);
        $startInner = getEx($startAngle, $innerR, $cx, $cy);
        $endInner = getEx($endAngle, $innerR, $cx, $cy);

        $largeArc = ($endAngle - $startAngle) <= 180 ? 0 : 1;

        return implode(' ', [
            "M", $startOuter['x'], $startOuter['y'],
            "A", $outerR, $outerR, 0, $largeArc, 1, $endOuter['x'], $endOuter['y'],
            "L", $endInner['x'], $endInner['y'],
            "A", $innerR, $innerR, 0, $largeArc, 0, $startInner['x'], $startInner['y'],
            "Z"
        ]);
    }
@endphp

<div class="relative w-full aspect-square max-w-[320px] mx-auto group">
    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[0_0_20px_rgba(0,0,0,0.5)]">
        <!-- Center Decoration -->
        <circle cx="50" cy="50" r="18" fill="#161b22" stroke="#222" stroke-width="0.5" />
        <text x="50" y="52" text-anchor="middle" font-size="6" fill="#444" font-weight="900" class="uppercase">Key</text>
        
        @foreach($keys as $num)
            @php
                // Camelot 12 is at top (12 o'clock).
                // Offset: Segment centered at top.
                // 12 o'clock = 0 deg (in our getEx calc).
                // Segment 12 spans -15 to +15 deg.
                // Segment 1 spans 15 to 45 deg.
                // Formula: ($num * 30) - 15?
                // If num=12, angle=360. 345 to 375 (15).
                
                // Let's adjust so 12 is top.
                // 12 -> 0 deg center.
                // 1 -> 30 deg center.
                $centerAngle = ($num === 12 ? 0 : $num * 30);
                $startAngle = $centerAngle - 15;
                $endAngle = $centerAngle + 15;

                // Keys
                $keyA = $num . 'A'; // Minor
                $keyB = $num . 'B'; // Major

                $isA_Active = $currentKey === $keyA;
                $isA_Valid = in_array($keyA, $compatibleKeys);
                
                $isB_Active = $currentKey === $keyB;
                $isB_Valid = in_array($keyB, $compatibleKeys);

                $colorA = $isA_Active ? '#ec4899' : ($isA_Valid ? '#ec489966' : '#2d333b');
                $colorB = $isB_Active ? '#3b82f6' : ($isB_Valid ? '#3b82f666' : '#22272e');
                
                // Opacity hover logic (handled by group-hover via CSS is hard for SVG paths, using simple colors)
            @endphp

            <!-- Outer Sector (B - Major) -->
            <path d="{{ describeArc($startAngle, $endAngle, $rMid + 0.5, $rOuter, $cx, $cy) }}" 
                fill="{{ $colorB }}" 
                stroke="#0d1117" stroke-width="0.5"
                class="transition-all duration-300 hover:opacity-80 cursor-pointer"
            >
                <title>{{ $keyB }}</title>
            </path>
             <text x="{{ getEx($centerAngle, ($rMid + $rOuter)/2, $cx, $cy)['x'] }}" 
                  y="{{ getEx($centerAngle, ($rMid + $rOuter)/2, $cx, $cy)['y'] + 1 }}" 
                  text-anchor="middle" 
                  font-size="4" 
                  font-weight="bold" 
                  fill="{{ $isB_Active ? '#fff' : ($isB_Valid ? '#fff' : '#ffffff40') }}"
                  class="pointer-events-none select-none"
            >{{ $num }}B</text>

            <!-- Inner Sector (A - Minor) -->
            <path d="{{ describeArc($startAngle, $endAngle, $rInner + 0.5, $rMid - 0.5, $cx, $cy) }}" 
                fill="{{ $colorA }}" 
                stroke="#0d1117" stroke-width="0.5"
                class="transition-all duration-300 hover:opacity-80 cursor-pointer"
            >
                <title>{{ $keyA }}</title>
            </path>
            <text x="{{ getEx($centerAngle, ($rInner + $rMid)/2, $cx, $cy)['x'] }}" 
                  y="{{ getEx($centerAngle, ($rInner + $rMid)/2, $cx, $cy)['y'] + 1 }}" 
                  text-anchor="middle" 
                  font-size="4" 
                  font-weight="bold" 
                  fill="{{ $isA_Active ? '#fff' : ($isA_Valid ? '#fff' : '#ffffff40') }}"
                  class="pointer-events-none select-none"
            >{{ $num }}A</text>
        @endforeach
    </svg>
    
    @if($currentKey)
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="text-center">
            <span class="block text-2xl font-black text-white tracking-tighter drop-shadow-md">{{ $currentKey }}</span>
            <span class="block text-[8px] font-bold text-white/50 uppercase tracking-widest mt-[-2px]">Camelot</span>
        </div>
    </div>
    @endif
</div>
