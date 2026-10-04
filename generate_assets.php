<?php

function createSvg($path, $title, $subtitle, $accent1 = '#1E293B', $accent2 = '#D97706', $iconSvg = '') {
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$accent1}"/>
      <stop offset="100%" stop-color="#0F172A"/>
    </linearGradient>
    <linearGradient id="accentGrad" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="{$accent2}"/>
      <stop offset="100%" stop-color="#F59E0B"/>
    </linearGradient>
    <radialGradient id="glow" cx="50%" cy="40%" r="50%">
      <stop offset="0%" stop-color="{$accent2}" stop-opacity="0.25"/>
      <stop offset="100%" stop-color="transparent" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <rect width="800" height="600" fill="url(#bgGrad)"/>
  <circle cx="400" cy="260" r="280" fill="url(#glow)"/>
  
  <!-- Grid lines -->
  <g opacity="0.08" stroke="#FFFFFF" stroke-width="1">
    <line x1="0" y1="150" x2="800" y2="150"/>
    <line x1="0" y1="300" x2="800" y2="300"/>
    <line x1="0" y1="450" x2="800" y2="450"/>
    <line x1="200" y1="0" x2="200" y2="600"/>
    <line x1="400" y1="0" x2="400" y2="600"/>
    <line x1="600" y1="0" x2="600" y2="600"/>
  </g>

  <!-- Hardware Icon Silhouette Box -->
  <g transform="translate(400, 240)">
    <rect x="-100" y="-100" width="200" height="200" rx="24" fill="#0B1329" stroke="url(#accentGrad)" stroke-width="2.5" opacity="0.9"/>
    {$iconSvg}
  </g>

  <!-- Badge -->
  <rect x="250" y="405" width="300" height="34" rx="17" fill="url(#accentGrad)" opacity="0.15"/>
  <text x="400" y="428" font-family="'Segoe UI', Roboto, sans-serif" font-size="14" font-weight="700" fill="{$accent2}" text-anchor="middle" letter-spacing="2">LAXMI HARDWARE SPECIFICATION</text>

  <!-- Title & Subtitle -->
  <text x="400" y="480" font-family="'Segoe UI', Roboto, sans-serif" font-size="30" font-weight="800" fill="#F8FAFC" text-anchor="middle">{$title}</text>
  <text x="400" y="520" font-family="'Segoe UI', Roboto, sans-serif" font-size="17" font-weight="500" fill="#94A3B8" text-anchor="middle">{$subtitle}</text>
</svg>
SVG;
    file_put_contents($path, $svg);
}

// Categories
$cats = [
    'hardware-fittings' => ['Hardware Fittings', 'Cabinet Hinges, Slides & Architectural Connectors', '#D97706'],
    'curtain-fittings' => ['Curtain Fittings', 'Tracks, Motorized Rods, Finials & Brackets', '#0284C7'],
    'plywood' => ['Plywood & Boards', 'BWP Marine, Commercial Ply, MDF & Boards', '#B45309'],
    'interior-accessories' => ['Interior Accessories', 'Profile Handles, Wire Baskets & Skirting', '#8B5CF6'],
    'kitchen-hardware' => ['Kitchen Hardware', 'Tandem Drawers, Tall Pantries & Organizers', '#EA580C'],
    'wardrobe-fittings' => ['Wardrobe Fittings', 'Sliding Doors, Wardrobe Lifts & Organizers', '#10B981'],
    'furniture-fittings' => ['Furniture Fittings', 'Legs, Castors, Connectors & Bed Fittings', '#6366F1'],
    'door-window-hardware' => ['Door & Window Hardware', 'Mortise Handles, Closers, Hinges & Stays', '#F59E0B'],
    'locks-security-hardware' => ['Locks & Security', 'Smart Digital Locks, Cylinders & Padlocks', '#EC4899'],
    'adhesives-fasteners' => ['Adhesives & Fasteners', 'Waterproof Adhesives, Sealants & Screws', '#14B8A6'],
    'bathroom-sanitary-fittings' => ['Bathroom & Sanitary Fittings', 'Luxury Faucets, Rain Showers, Basins & Bath Accessories', '#0EA5E9'],
    'plumbing-pipe-lines' => ['Plumbing & Pipe Lines', 'CPVC, UPVC, SWR High-Pressure Pipes & Fittings', '#2563EB'],
];

foreach ($cats as $slug => $data) {
    $icon = '<circle cx="0" cy="0" r="45" fill="none" stroke="#D97706" stroke-width="4"/><path d="M-25,-10 L0,-35 L25,-10 L15,-10 L15,30 L-15,30 L-15,-10 Z" fill="#F59E0B"/>';
    createSvg("public/images/categories/{$slug}.svg", $data[0], $data[1], '#1E293B', $data[2], $icon);
}

// Products
$products = [
    'hinge' => ['Soft-Close Concealed Hinge', '110° Clip-On Hydraulic Cabinet Hinge', '#D97706'],
    'tandem' => ['Slim Tech Tandem Box Drawer', 'Double-Wall Soft-Close Drawer System 500mm', '#EA580C'],
    'slide' => ['Telescopic Soft Close Ball Bearing Slides', 'Heavy Duty 45kg Full Extension Runner', '#3B82F6'],
    'curtain-track' => ['Motorized Heavy-Duty Curtain Track', 'Quiet Smart Home Compatible Track System', '#0284C7'],
    'marine-ply' => ['Platinum BWP Marine Plywood', 'IS:710 Boiling Water Proof Grade Ply 18mm', '#B45309'],
    'smart-lock' => ['Biometric Smart Digital Door Lock', 'Fingerprint, RFID, Passcode & App Security', '#EC4899'],
    'wardrobe-lift' => ['Ergonomic Wardrobe Lift Mechanism', 'Hydraulic Pull-Down Hanging Rail System', '#10B981'],
    'corner-carousel' => ['Magic Corner Kitchen Carousel Unit', 'Smooth Swivel S-Shaped Storage Basket', '#F59E0B'],
    'mortise-handle' => ['Architectural Solid Brass Mortise Handle', 'Satin Matt Finish Luxury Door Lever Set', '#D97706'],
    'adhesive' => ['D3 Waterproof Synthetic Resin Adhesive', 'High Strength Woodworking Polyvinyl Adhesive', '#14B8A6'],
    'profile-handle' => ['G-Profile Concealed Edge Kitchen Handle', 'Anodized Black Aluminum Edge Pull 3M', '#64748B'],
    'bed-lift' => ['Pneumatic Bed Storage Lift Mechanism', 'Heavy Duty Gas Spring Lift for King Beds', '#6366F1'],
    'bath-faucet' => ['Luxury Single Lever Basin Mixer', 'Solid Brass Ceramic Disc Cartridge Faucet', '#0EA5E9'],
    'rain-shower' => ['Thermostatic Concealed Rain Shower', '300mm Ultra-Slim Stainless Steel Overhead Shower', '#0284C7'],
    'cpvc-pipes' => ['SDR-11 High Pressure CPVC Pipe Line', 'Lead-Free Hot & Cold Potable Water Piping', '#2563EB'],
    'swr-drainage' => ['Ring-Fit SWR Soil & Waste Pipe Line', 'Leak-Proof Rubber Ring Joint Acoustic Drainage', '#3B82F6'],
];

foreach ($products as $slug => $data) {
    $icon = '<rect x="-40" y="-40" width="80" height="80" rx="12" fill="#D97706" opacity="0.2"/><path d="M-20,0 L0,-20 L20,0 L0,20 Z" fill="#F59E0B"/>';
    createSvg("public/images/showcase/{$slug}.svg", $data[0], $data[1], '#0F172A', $data[2], $icon);
}

// Services
$services = [
    'hardware-supply' => ['Interior Hardware Supply', 'Complete range of hinges, slides & connectors for designers'],
    'kitchen-solutions' => ['Kitchen Hardware Solutions', 'Modular kitchen baskets, drawers & space-saving fittings'],
    'wardrobe-hardware' => ['Wardrobe Hardware', 'Premium sliding systems, lifts & storage accessories'],
    'curtain-fittings' => ['Curtain Fittings', 'Motorized & manual curtain tracks, rods and finials'],
    'plywood-boards' => ['Plywood & Boards', 'Certified marine ply, commercial ply & high-density boards'],
    'project-supply' => ['Project Supply', 'Bulk wholesale hardware supply for turnkey developers'],
];

foreach ($services as $slug => $data) {
    createSvg("public/images/services/{$slug}.svg", $data[0], $data[1], '#1E293B', '#D97706');
}

// Projects
$projects = [
    'sky-villa' => ['Sky Villa Luxury Interiors', 'Complete Hettich soft-close hardware & brass handles'],
    'corporate-hq' => ['Corporate HQ Workspaces', 'Heavy-duty drawer channels, glass connectors & locks'],
    'chef-kitchen' => ['Chef\'s Gourmet Modular Kitchen', 'Hafele tandem drawer systems & tall pantry units'],
    'master-wardrobe' => ['Walk-In Master Wardrobe', 'Ebco sliding wardrobe systems & hydraulic lifts'],
    'minimalist-penthouse' => ['Minimalist Penthouse Living', 'Concealed door hinges, flush profile handles & trims'],
    'resort-suites' => ['Boutique Resort Suites', 'Greenply BWP marine plywood & Yale digital locks'],
];

foreach ($projects as $slug => $data) {
    createSvg("public/images/projects/{$slug}.svg", $data[0], $data[1], '#0F172A', '#D97706');
}

// Blog
$blogs = [
    'hinge-guide' => ['The Ultimate Cabinet Hinge Guide', 'Choosing between full overlay, half overlay & inset hinges'],
    'plywood-guide' => ['Marine Ply vs Commercial Ply', 'Everything architects must know before specifying plywood'],
    'kitchen-storage' => ['Smart Kitchen Corner Solutions', 'Maximizing dead kitchen corners with magic carousels'],
    'smart-locks' => ['Smart Digital Locks Guide', 'Enhancing home security with biometric & PIN smart locks'],
    'sliding-wardrobe' => ['Sliding Wardrobe Systems Guide', 'Top hung vs bottom rolling systems compared'],
];

foreach ($blogs as $slug => $data) {
    createSvg("public/images/blog/{$slug}.svg", $data[0], $data[1], '#1E293B', '#D97706');
}

// Placeholder
createSvg("public/images/placeholder-hardware.svg", 'Laxmi Hardware', 'Premium Interior Showcase Item', '#0F172A', '#D97706');

echo "SVG assets generated successfully.\n";
