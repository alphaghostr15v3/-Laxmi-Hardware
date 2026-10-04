<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        Admin::updateOrCreate(
            ['email' => 'admin@laxmihardware.com'],
            [
                'name' => 'Laxmi Hardware Administrator',
                'password' => Hash::make('Admin@12345'),
                'role' => 'superadmin',
                'avatar' => null,
            ]
        );

        // 2. Website Settings
        $settings = [
            'company_name' => 'Laxmi Hardware',
            'tagline' => 'Complete Interior Hardware, Bathroom Fittings & Pipe Line Solutions Under One Roof',
            'phone' => '+91 98765 43210',
            'phone_alt' => '+91 98234 56789',
            'whatsapp' => '919876543210',
            'email' => 'info@laxmihardware.com',
            'email_sales' => 'sales@laxmihardware.com',
            'address' => 'Shop No. 12-15, Hardware Plaza, Ring Road, Industrial Area, Surat, Gujarat 395002, India',
            'business_hours' => 'Mon - Sat: 9:00 AM - 8:30 PM | Sunday: 10:00 AM - 2:00 PM',
            'gst_number' => '24AAACL1234P1ZR',
            'stat_experience' => '10+',
            'stat_products' => '750+',
            'stat_categories' => '120+',
            'stat_customers' => '1500+',
            'facebook_url' => 'https://facebook.com/laxmihardware',
            'instagram_url' => 'https://instagram.com/laxmihardware',
            'linkedin_url' => 'https://linkedin.com/company/laxmihardware',
            'youtube_url' => 'https://youtube.com/@laxmihardware',
            'meta_title' => 'Laxmi Hardware — Complete Interior Hardware, Sanitaryware & Pipe Line Solutions',
            'meta_description' => 'Quality interior hardware, plywood, curtain fittings, luxury bathroom & sanitary fittings, CPVC/UPVC/SWR pipe lines for residential and commercial spaces.',
            'meta_keywords' => 'interior hardware, cabinet hinges, kitchen tandem drawers, wardrobe fittings, marine plywood, curtain tracks, bathroom fittings, sanitaryware, CPVC pipes, UPVC pipes, SWR drainage, Astral pipes, Jaquar bath fittings, Surat hardware',
            'google_map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119066.41709425492!2d72.7522557551064!3d21.170240149023456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e59411d1563%3A0xfe4558290938b042!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val, 'group' => 'general']);
        }

        // 3. Categories & Subcategories
        $categoriesData = [
            [
                'name' => 'Hardware Fittings',
                'slug' => 'hardware-fittings',
                'description' => 'Cabinet hinges, drawer channels, handles, brackets and connectors.',
                'image' => '/images/categories/hardware-fittings.svg',
                'icon' => 'bi-tools',
                'subcategories' => [
                    'Soft Close Hinges',
                    'Telescopic Drawer Slides',
                    'Architectural Handles & Knobs',
                    'Heavy Duty Brackets & Connectors',
                    'Magnetic Catchers & Buffers',
                ],
            ],
            [
                'name' => 'Curtain Fittings',
                'slug' => 'curtain-fittings',
                'description' => 'Curtain rods, tracks, brackets, rings and accessories.',
                'image' => '/images/categories/curtain-fittings.svg',
                'icon' => 'bi-window-split',
                'subcategories' => [
                    'Motorized Curtain Tracks',
                    'Aluminum Curtain Rails',
                    'Decorative Rods & Finials',
                    'Curtain Brackets & Holdbacks',
                    'Silent Glider Rings',
                ],
            ],
            [
                'name' => 'Plywood',
                'slug' => 'plywood',
                'description' => 'Commercial plywood, marine plywood, MDF, HDF and block boards.',
                'image' => '/images/categories/plywood.svg',
                'icon' => 'bi-layers',
                'subcategories' => [
                    'BWP Marine Grade Plywood',
                    'MR Commercial Plywood',
                    'Pre-Laminated MDF Boards',
                    'Calibrated High Density HDF',
                    'Pine Block Boards',
                ],
            ],
            [
                'name' => 'Kitchen Hardware',
                'slug' => 'kitchen-hardware',
                'description' => 'Kitchen baskets, corner units, drawer systems and organizers.',
                'image' => '/images/categories/kitchen-hardware.svg',
                'icon' => 'bi-cup-hot',
                'subcategories' => [
                    'Slim Tandem Box Drawers',
                    'Corner Magic Units & Carousels',
                    'Tall Pantry Pull-Out Units',
                    'SS 304 Wire Baskets',
                    'Under-Sink Storage Organizers',
                ],
            ],
            [
                'name' => 'Wardrobe Fittings',
                'slug' => 'wardrobe-fittings',
                'description' => 'Wardrobe lifts, sliding systems, hangers and accessories.',
                'image' => '/images/categories/wardrobe-fittings.svg',
                'icon' => 'bi-door-closed',
                'subcategories' => [
                    'Heavy Duty Sliding Door Systems',
                    'Hydraulic Wardrobe Lifts',
                    'Pull-out Trouser & Tie Racks',
                    'Jewelry Drawer Inserts',
                    'Wardrobe LED Sensor Rods',
                ],
            ],
            [
                'name' => 'Furniture Fittings',
                'slug' => 'furniture-fittings',
                'description' => 'Furniture legs, connectors, handles and supporting hardware.',
                'image' => '/images/categories/furniture-fittings.svg',
                'icon' => 'bi-box-seam',
                'subcategories' => [
                    'Designer Furniture Legs & Bush',
                    'Heavy Duty Bed Lift Mechanisms',
                    'Castors & Swivel Wheels',
                    'Minifix & Cam Lock Connectors',
                    'Table Flap Hinges & Stays',
                ],
            ],
            [
                'name' => 'Interior Accessories',
                'slug' => 'interior-accessories',
                'description' => 'Interior finishing and functional accessories.',
                'image' => '/images/categories/interior-accessories.svg',
                'icon' => 'bi-stars',
                'subcategories' => [
                    'Aluminum G & J Profile Handles',
                    'LED Aluminum Profile Diffusers',
                    'Floor Skirting & Transition Trims',
                    'Ventilation Grilles & Grommets',
                ],
            ],
            [
                'name' => 'Door & Window Hardware',
                'slug' => 'door-window-hardware',
                'description' => 'Handles, locks, hinges and related products.',
                'image' => '/images/categories/door-window-hardware.svg',
                'icon' => 'bi-house-door',
                'subcategories' => [
                    'Solid Brass Mortise Handles',
                    'Concealed Hydraulic Door Closers',
                    'Heavy Duty Tower Bolts & Aldrops',
                    'Stainless Steel Bearing Hinges',
                ],
            ],
            [
                'name' => 'Locks & Security Hardware',
                'slug' => 'locks-security-hardware',
                'description' => 'Smart biometric digital door locks, deadbolts and security cylinders.',
                'image' => '/images/categories/locks-security-hardware.svg',
                'icon' => 'bi-shield-lock',
                'subcategories' => [
                    'Smart Biometric Door Locks',
                    'High Security Computer Key Mortise',
                    'Master Key Pin Cylinders',
                    'Digital Furniture & Drawer Locks',
                ],
            ],
            [
                'name' => 'Adhesives & Fasteners',
                'slug' => 'adhesives-fasteners',
                'description' => 'Waterproof wood glues, silicone sealants, screws and anchor fixings.',
                'image' => '/images/categories/adhesives-fasteners.svg',
                'icon' => 'bi-pin-angle',
                'subcategories' => [
                    'Waterproof Wood Adhesives (D3/D4)',
                    'Weatherproof Silicone Sealants',
                    'Stainless Steel Drywall Screws',
                    'Nylon Wall Plugs & Fasteners',
                ],
            ],
            [
                'name' => 'Bathroom & Sanitary Fittings',
                'slug' => 'bathroom-sanitary-fittings',
                'description' => 'Luxury bath faucets, overhead rain showers, diverters, health faucets, vanity basins and accessories.',
                'image' => '/images/categories/bathroom-sanitary-fittings.svg',
                'icon' => 'bi-water',
                'subcategories' => [
                    'Single Lever Basin Mixers & Faucets',
                    'Concealed Thermostatic Shower Diverters',
                    'Overhead Rain Showers & Hand Showers',
                    'Luxury Sanitaryware & Wall-Hung Basins',
                    'Bathroom Brass Accessories & Drains',
                ],
            ],
            [
                'name' => 'Plumbing & Pipe Lines',
                'slug' => 'plumbing-pipe-lines',
                'description' => 'CPVC hot & cold water pipes, UPVC pressure pipes, SWR drainage lines and high-pressure fittings.',
                'image' => '/images/categories/plumbing-pipe-lines.svg',
                'icon' => 'bi-diagram-3',
                'subcategories' => [
                    'CPVC Hot & Cold Water Pipes & Fittings',
                    'UPVC Heavy Pressure Plumbing Lines',
                    'SWR Soil, Waste & Rainwater Drainage Pipes',
                    'Brass Ball Valves & Precision Couplers',
                ],
            ],
        ];

        $categoryMap = [];
        $subcategoryMap = [];

        foreach ($categoriesData as $idx => $catItem) {
            $cat = Category::create([
                'name' => $catItem['name'],
                'slug' => $catItem['slug'],
                'description' => $catItem['description'],
                'image' => $catItem['image'],
                'icon' => $catItem['icon'],
                'sort_order' => $idx + 1,
                'status' => true,
            ]);
            $categoryMap[$cat->slug] = $cat;

            foreach ($catItem['subcategories'] as $subName) {
                $sub = Subcategory::create([
                    'category_id' => $cat->id,
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'description' => "Precision engineered {$subName} for modern architectural and cabinet requirements.",
                    'status' => true,
                ]);
                $subcategoryMap[$cat->slug . '::' . $sub->slug] = $sub;
            }
        }

        // 4. Brands
        $brandsData = [
            ['name' => 'Hettich', 'slug' => 'hettich', 'description' => 'German engineering pioneer renowned worldwide for precision hinges, drawer runners, and sliding systems.', 'featured' => true],
            ['name' => 'Hafele', 'slug' => 'hafele', 'description' => 'International leader in German hardware, architectural fittings, and smart electronic locks.', 'featured' => true],
            ['name' => 'Godrej', 'slug' => 'godrej', 'description' => 'India\'s most trusted lock and security brand with state-of-the-art mortise and digital locking systems.', 'featured' => true],
            ['name' => 'Ebco', 'slug' => 'ebco', 'description' => 'Premier manufacturer of innovative furniture fittings, kitchen baskets, and office hardware.', 'featured' => true],
            ['name' => 'Blum', 'slug' => 'blum', 'description' => 'Austrian specialist in high-end lift systems, soft-close hinges, and luxury tandem box systems.', 'featured' => true],
            ['name' => 'Greenply', 'slug' => 'greenply', 'description' => 'India\'s premier manufacturer of IS:710 Marine Grade waterproof plywood and decorative blockboards.', 'featured' => true],
            ['name' => 'CenturyPly', 'slug' => 'centuryply', 'description' => 'Pioneers of firewall and virokill technology plywood, calibrated boards, and architectural veneers.', 'featured' => true],
            ['name' => 'Dorset', 'slug' => 'dorset', 'description' => 'Elegance in architectural door hardware, designer mortise handles, and concealed door closers.', 'featured' => true],
            ['name' => 'Jaquar', 'slug' => 'jaquar', 'description' => 'India\'s premier luxury bathroom fittings, faucets, sensory showers, and sanitaryware brand.', 'featured' => true],
            ['name' => 'Kohler', 'slug' => 'kohler', 'description' => 'Global hallmark of luxury bathroom fixtures, thermostatic shower systems, and designer basins.', 'featured' => true],
            ['name' => 'Astral Pipes', 'slug' => 'astral-pipes', 'description' => 'India\'s leading manufacturer of CPVC, UPVC, and SWR piping systems with NSF international certifications.', 'featured' => true],
            ['name' => 'Ashirvad Pipes', 'slug' => 'ashirvad-pipes', 'description' => 'Pioneering CPVC plumbing, acoustic drainage lines, and precision ball valves for residential towers.', 'featured' => true],
        ];

        $brandMap = [];
        foreach ($brandsData as $bData) {
            $brand = Brand::create([
                'name' => $bData['name'],
                'slug' => $bData['slug'],
                'description' => $bData['description'],
                'logo' => null,
                'featured' => $bData['featured'],
                'status' => true,
            ]);
            $brandMap[$bData['slug']] = $brand;
        }

        // 5. Products
        $productsData = [
            [
                'category_slug' => 'hardware-fittings',
                'sub_slug' => 'soft-close-hinges',
                'brand_slug' => 'hettich',
                'name' => 'Sensys 8645i 110° Soft-Close Concealed Hinge',
                'slug' => 'hettich-sensys-8645i-soft-close-hinge',
                'sku' => 'LX-HT-8645I',
                'main_image' => '/images/showcase/hinge.svg',
                'short_description' => 'Premium clip-on concealed hinge with integrated Silent System soft-closing buffer.',
                'description' => 'The Sensys 8645i hinge from Hettich combines sophisticated styling with smooth, silent operation. Its invisible integrated damper cushions door closure starting from an opening angle of approx. 35°. Ideal for luxury modular kitchens, vanity cabinets, and residential wardrobes.',
                'features' => json_encode([
                    'Integrated Silent System with automatic self-closing',
                    'Opening angle: 110 degrees for convenient cabinet access',
                    'Cup diameter: 35 mm, cup depth: 12.8 mm',
                    '3D Cam-guided adjustment (height ±2mm, side ±2mm, depth +3/-2mm)',
                    'Tool-free clip-on installation onto mounting plate',
                    'Corrosion-resistant nickel-plated steel finish',
                ]),
                'applications' => 'Modular kitchens, overhead wall cabinets, master wardrobes, office credenzas, and vanity units.',
                'installation' => 'Drill 35mm cup hole with 52mm drilling pattern. Use compatible clip-on wing mounting plate (0mm or 3mm). Fine-tune alignment using the integrated 3D eccentric screws.',
                'featured' => true,
                'specs' => [
                    'Material' => 'Nickel Plated Steel',
                    'Opening Angle' => '110°',
                    'Cup Diameter' => '35 mm',
                    'Door Thickness' => '15 mm – 24 mm',
                    'Closing Mechanism' => 'Hydraulic Soft-Close',
                    'Mounting' => 'Tool-less Clip-On',
                ],
            ],
            [
                'category_slug' => 'hardware-fittings',
                'sub_slug' => 'telescopic-drawer-slides',
                'brand_slug' => 'hettich',
                'name' => 'Quadro V6 4D Full Extension Soft-Close Runners',
                'slug' => 'hettich-quadro-v6-4d-runners',
                'sku' => 'LX-HT-QV6-500',
                'main_image' => '/images/showcase/slide.svg',
                'short_description' => 'Precision concealed undermount drawer slide with 4D front alignment and 30kg load capacity.',
                'description' => 'Hettich Quadro V6 4D undermount runners deliver flawless gliding performance. The high-precision steel balls guide the runner with silky smoothness, while the integrated Silent System brings the drawer to a gentle halt.',
                'features' => json_encode([
                    'Full extension runner for 100% drawer interior accessibility',
                    'Integrated Silent System soft closing damping',
                    '4D front adjustment: height, side, tilt, and depth',
                    'Load capacity up to 30 kg dynamic weight',
                    'Concealed undermount design keeps hardware hidden',
                ]),
                'applications' => 'Modular kitchen wooden drawers, living room media units, executive desks.',
                'installation' => 'Mount under drawer box following standardized 32mm system drilling holes. Engage drawer onto catches until an audible click confirms locking.',
                'featured' => true,
                'specs' => [
                    'Nominal Length' => '500 mm',
                    'Load Capacity' => '30 kg',
                    'Extension' => 'Full Extension',
                    'Adjustment' => '4D (Height, Side, Tilt, Depth)',
                    'Technology' => 'Ball Bearing Under-Mount',
                ],
            ],
            [
                'category_slug' => 'kitchen-hardware',
                'sub_slug' => 'slim-tandem-box-drawers',
                'brand_slug' => 'blum',
                'name' => 'LEGRABOX Pure Slim Double-Wall Drawer System',
                'slug' => 'blum-legrabox-pure-slim-drawer-system',
                'sku' => 'LX-BL-LGBX-500',
                'main_image' => '/images/showcase/tandem.svg',
                'short_description' => 'Linear, minimalist 12.8mm ultra-slim drawer sides with BLUMOTION soft-close.',
                'description' => 'LEGRABOX by Blum stands out for its sleek, architectural profile. Straight on the inside and outside, the drawer walls measure a svelte 12.8 mm. Synchronized feather-light gliding motion combines with reliable BLUMOTION dampening.',
                'features' => json_encode([
                    'Ultra-slim 12.8 mm straight double-walled side profiles',
                    'Synchronized BLUMOTION adaptive damping',
                    'Dynamic carrying capacity: 40 kg & 70 kg options',
                    'Tool-free 3-dimensional front panel adjustment',
                    'Premium Orion Gray and Silk White matt finishes',
                ]),
                'applications' => 'High-end modular kitchen cutlery, pan drawers, and tall pantry pullouts.',
                'installation' => 'Fasten cabinet profiles horizontally. Assemble base and back panel into metal sides. Clip front panel with LEGRABOX front brackets.',
                'featured' => true,
                'specs' => [
                    'Wall Thickness' => '12.8 mm',
                    'Nominal Length' => '500 mm',
                    'Finish' => 'Orion Gray Matt Powder Coat',
                    'Load Rating' => '40 kg Dynamic',
                    'Mechanism' => 'BLUMOTION Fluid Damping',
                ],
            ],
            [
                'category_slug' => 'curtain-fittings',
                'sub_slug' => 'motorized-curtain-tracks',
                'brand_slug' => 'hafele',
                'name' => 'Hafele Smart Motorized Heavy-Duty Curtain Track',
                'slug' => 'hafele-smart-motorized-curtain-track',
                'sku' => 'LX-HF-MCT-4M',
                'main_image' => '/images/showcase/curtain-track.svg',
                'short_description' => 'Whisper-quiet motorized curtain track compatible with smart home automation and RF remote.',
                'description' => 'Engineered for luxury villas, penthouses, and high-ceiling master bedrooms, Hafele motorized curtain tracks feature quiet belt drives with touch-motion triggering (gently tugging the drape activates automated movement).',
                'features' => json_encode([
                    'Ultra-low noise level: < 30 dB silent motor',
                    'Touch Motion: curtain moves automatically when pulled lightly by hand',
                    'Integrated Wi-Fi & RF receiver: control via smartphone app or Alexa/Google',
                    'Soft start and soft stop motion profiling',
                    'Supports heavy draperies up to 60 kg weight',
                ]),
                'applications' => 'Double-height living rooms, home theatres, luxury hotel master bedrooms.',
                'installation' => 'Ceiling or wall mounting with included snap-in heavy brackets. Connect to 230V AC or standard 24V DC power point.',
                'featured' => true,
                'specs' => [
                    'Track Length' => 'Customizable up to 6 Meters',
                    'Motor Noise' => '< 30 dB',
                    'Curtain Weight' => 'Up to 60 kg',
                    'Smart Protocols' => 'RF 433MHz, Wi-Fi, RS485 Automation',
                    'Material' => 'Extruded Aircraft Grade Aluminum',
                ],
            ],
            [
                'category_slug' => 'plywood',
                'sub_slug' => 'bwp-marine-grade-plywood',
                'brand_slug' => 'greenply',
                'name' => 'Green Platinum BWP Marine Plywood IS:710',
                'slug' => 'greenply-platinum-bwp-marine-plywood',
                'sku' => 'LX-GP-PLT-18',
                'main_image' => '/images/showcase/marine-ply.svg',
                'short_description' => '100% selected hardwood timber with unextended Phenol Formaldehyde resin and 30-year warranty.',
                'description' => 'Green Platinum Marine Plywood is manufactured from carefully selected hardwood veneers bonded with fortified Phenol Formaldehyde (PF) synthetic resin under extreme heat and pressure. It withstands 72 hours of boiling water test without delamination.',
                'features' => json_encode([
                    'Conforms strictly to IS:710 Marine Grade specifications',
                    'Calibrated thickness for zero surface waviness',
                    'Treated with Dual Pro-tech against termites, borer, and fungus',
                    'Fire-retardant and zero emissions for indoor air quality',
                    '30 Years warranty from Greenply',
                ]),
                'applications' => 'Kitchen carcasses, bathroom vanities, external woodwork, wardrobe carcasses, and false ceilings.',
                'installation' => 'Store sheets horizontally off the ground. Cut with 60-80T carbide saw blades. Seal exposed core edges with waterproof sealant.',
                'featured' => true,
                'specs' => [
                    'Grade' => 'BWP (Boiling Water Proof) IS:710',
                    'Standard Thickness' => '18 mm (Also available in 6, 9, 12, 16, 25 mm)',
                    'Sheet Size' => '8 ft x 4 ft (2440 x 1220 mm)',
                    'Resin' => '100% Undiluted Phenol Formaldehyde',
                    'Borer & Termite' => 'Chemically Treated 100% Resistant',
                ],
            ],
            [
                'category_slug' => 'wardrobe-fittings',
                'sub_slug' => 'hydraulic-wardrobe-lifts',
                'brand_slug' => 'ebco',
                'name' => 'Ebco Ergonomic Hydraulic Pull-Down Wardrobe Lift',
                'slug' => 'ebco-ergonomic-hydraulic-wardrobe-lift',
                'sku' => 'LX-EB-WRL-900',
                'main_image' => '/images/showcase/wardrobe-lift.svg',
                'short_description' => 'Gas-spring hydraulic pull-down wardrobe hanger mechanism for high upper cabinets.',
                'description' => 'Maximize high-ceiling wardrobe spaces without ladders. The Ebco Wardrobe Lift smoothly pulls down clothes from top compartments to an ergonomic chest level, then gently guides them back up.',
                'features' => json_encode([
                    'Telescopic width adjustment: 750 mm to 1150 mm',
                    'Soft return hydraulic damping mechanism prevents slamming',
                    'Ergonomic center grip handle for effortless pull-down',
                    'Load carrying capacity up to 15 kg of hanging garments',
                    'Matte Anthracite and Chrome plated steel finish',
                ]),
                'applications' => 'High-ceiling master wardrobes, walk-in closets, boutique dressing rooms.',
                'installation' => 'Fasten side brackets to wardrobe carcass with 8 fixing screws per side. Ensure minimum internal cabinet depth of 500mm.',
                'featured' => true,
                'specs' => [
                    'Width Range' => '750 mm - 1150 mm Adjustable',
                    'Load Capacity' => '12 - 15 kg',
                    'Mechanism' => 'Pneumatic Gas Springs + Damper',
                    'Internal Depth Required' => '500 mm minimum',
                    'Finish' => 'Electrostatic Anthracite + Chrome',
                ],
            ],
            [
                'category_slug' => 'kitchen-hardware',
                'sub_slug' => 'corner-magic-units-carousels',
                'brand_slug' => 'hafele',
                'name' => 'Hafele Magic Corner II Swivel Storage Unit',
                'slug' => 'hafele-magic-corner-ii-unit',
                'sku' => 'LX-HF-MGC-900',
                'main_image' => '/images/showcase/corner-carousel.svg',
                'short_description' => 'Intelligent corner storage with dual swivelling trays and soft closing action.',
                'description' => 'Unlock inaccessible dead corner cabinet spaces in modular kitchens. Opening the cabinet door effortlessly pulls front baskets outside while simultaneously sliding back baskets into easy reach.',
                'features' => json_encode([
                    'Complete access to deep corner cabinets',
                    'Soft-closing hydraulic dampener on both pull-out and return stroke',
                    'Non-slip solid melamine bases with chrome steel railing',
                    'Independent tray height adjustability',
                    'Available in Left-hand and Right-hand opening variants',
                ]),
                'applications' => 'L-shaped and U-shaped modular kitchen blind corner cabinets.',
                'installation' => 'Requires minimum internal cabinet width of 900mm and door width of 450mm. Mount base plate onto cabinet floor with alignment template.',
                'featured' => true,
                'specs' => [
                    'Carcass Width' => '900 mm - 1000 mm',
                    'Door Width' => '450 mm Minimum',
                    'Basket Finish' => 'Chrome Plated Steel with White Solid Base',
                    'Total Capacity' => '32 kg (Front: 14 kg, Rear: 18 kg)',
                ],
            ],
            [
                'category_slug' => 'locks-security-hardware',
                'sub_slug' => 'smart-biometric-door-locks',
                'brand_slug' => 'godrej',
                'name' => 'Godrej Advantis Revolution Smart Digital Door Lock',
                'slug' => 'godrej-advantis-revolution-smart-lock',
                'sku' => 'LX-GD-ADV-REV',
                'main_image' => '/images/showcase/smart-lock.svg',
                'short_description' => '5-in-1 access security lock with 360° biometric sensor, RFID, PIN, mobile key & mechanical key.',
                'description' => 'The Godrej Advantis Revolution provides cutting-edge electronic access security for main entrance doors. Features robust steel mortise deadbolts, privacy lockout modes, break-in tamper alarm, and fire sensor unlocking.',
                'features' => json_encode([
                    '5 Access Modes: Fingerprint, RFID card, PIN, Mobile App, Mechanical Key',
                    'Stores up to 100 Fingerprints and 100 RFID Cards',
                    'Spy Code PIN masking prevents shoulder-surfing',
                    'Automatic motor deadlock upon door closing',
                    'Emergency USB Type-C external power jumping port',
                    'Break-in tamper siren and thermal shock sensor',
                ]),
                'applications' => 'Residential apartment main entrance doors, corporate executive suites, luxury villas.',
                'installation' => 'Mortise installation on doors with thickness 35mm – 65mm. Standard mortise lock body cutout template included.',
                'featured' => true,
                'specs' => [
                    'Door Thickness' => '35 mm to 65 mm',
                    'Lock Body' => 'Reinforced Stainless Steel Mortise 3-Deadbolt',
                    'Power Source' => '4 x AA Alkaline Batteries (up to 12 months)',
                    'Sensor Type' => 'Semiconductor 360° Fingerprint (< 0.4 sec)',
                    'Emergency Backup' => 'USB-C 5V Port + 2 Dimple Keys',
                ],
            ],
            [
                'category_slug' => 'door-window-hardware',
                'sub_slug' => 'solid-brass-mortise-handles',
                'brand_slug' => 'dorset',
                'name' => 'Dorset Royale Solid Forged Brass Mortise Handle',
                'slug' => 'dorset-royale-brass-mortise-handle',
                'sku' => 'LX-DS-RYL-01',
                'main_image' => '/images/showcase/mortise-handle.svg',
                'short_description' => 'Architectural forged brass designer door handle in Antique Copper & Satin Gold finishes.',
                'description' => 'The Dorset Royale series embodies pure elegance. Forged from high-grade virgin brass, its contoured grip offers balanced tactile feedback. Equipped with high-cycle spring cassettes for smooth, droop-free lever action.',
                'features' => json_encode([
                    'Forged from heavy virgin brass alloy for lifelong durability',
                    'PVD coating ensures superior scratch and tarnish resistance',
                    'Double-spring mechanism prevents lever sagging over time',
                    'Concealed screw rose escutcheons for clean aesthetics',
                    'Suitable for mortise locks with 85mm or 72mm centers',
                ]),
                'applications' => 'Main entrance doors, bedroom doors, conference rooms, luxury residences.',
                'installation' => 'Fasten rose escutcheons with through-bolts on door thickness 32mm to 55mm.',
                'featured' => false,
                'specs' => [
                    'Material' => 'Virgin Forged Brass',
                    'Finish' => 'PVD Satin Gold / Antique Matt Copper',
                    'Spindle Size' => '8 x 8 mm hardened steel',
                    'Cycle Tested' => '200,000 operational cycles',
                ],
            ],
            [
                'category_slug' => 'interior-accessories',
                'sub_slug' => 'aluminum-g-j-profile-handles',
                'brand_slug' => 'ebco',
                'name' => 'Ebco Sleek Anodized G-Profile Edge Pull Handle',
                'slug' => 'ebco-sleek-g-profile-edge-pull',
                'sku' => 'LX-EB-GPRF-3M',
                'main_image' => '/images/showcase/profile-handle.svg',
                'short_description' => 'Minimalist continuous edge pull profile in Matt Black & Champagne Gold 3-meter lengths.',
                'description' => 'Achieve ultra-modern handleless kitchens and wardrobes with continuous G-profile channels. Made from extruded aerospace aluminum with thick micro-anodizing.',
                'features' => json_encode([
                    'Clean handle-less seamless cabinetry aesthetics',
                    'High durability anodized finish resistant to kitchen moisture and oil',
                    'Pre-grooved channel for quick push-in assembly with end caps',
                    'Available in Matt Black, Brushed Rose Gold, and Silver Satin',
                ]),
                'applications' => 'Modular kitchen base cabinets, overhead shutters, tall wardrobe panels.',
                'installation' => 'Slot into 18mm board edge groove and fix using countersunk wood screws.',
                'featured' => false,
                'specs' => [
                    'Length' => '3000 mm (Cut-to-size)',
                    'Board Compatibility' => '18 mm - 19 mm shutters',
                    'Material' => 'Grade 6063-T6 Extruded Aluminum',
                ],
            ],
            [
                'category_slug' => 'adhesives-fasteners',
                'sub_slug' => 'waterproof-wood-adhesives-d3-d4',
                'brand_slug' => 'centuryply',
                'name' => 'Century Pro-Bond Waterproof D3 Wood Adhesive',
                'slug' => 'century-pro-bond-d3-wood-adhesive',
                'sku' => 'LX-CP-PB-05',
                'main_image' => '/images/showcase/adhesive.svg',
                'short_description' => 'Advanced Cross-Linking Polyvinyl Acetate adhesive with unmatched bonding strength.',
                'description' => 'Engineered specifically for bonding laminates to plywood, MDF, and particle boards. Offers fast setting times, high heat resistance, and water barrier protection under humid Indian climate conditions.',
                'features' => json_encode([
                    'Meets European EN 204 D3 waterproof standard',
                    'Fast clamping time: achieves handling strength in 2 to 4 hours',
                    'High spread rate with excellent coverage per kilogram',
                    'Resists boiling humidity and fungal attacks',
                ]),
                'applications' => 'Laminate pressing onto plywood, edge banding, solid wood jointing, veneer application.',
                'installation' => 'Apply evenly using fine notched trowel on both bonding surfaces. Clamp with uniform pressure for 3-4 hours.',
                'featured' => false,
                'specs' => [
                    'Base' => 'Modified PVA Emulsion',
                    'Water Resistance' => 'DIN EN 204 D3 Grade',
                    'Pack Sizes' => '1 kg, 5 kg, 20 kg, 50 kg Pails',
                    'Setting Time' => '2 - 4 hours at room temp',
                ],
            ],
            [
                'category_slug' => 'furniture-fittings',
                'sub_slug' => 'heavy-duty-bed-lift-mechanisms',
                'brand_slug' => 'ebco',
                'name' => 'Ebco Heavy Duty Gas-Lift Bed Storage Mechanism',
                'slug' => 'ebco-heavy-duty-gas-lift-bed-storage',
                'sku' => 'LX-EB-BDL-150',
                'main_image' => '/images/showcase/bed-lift.svg',
                'short_description' => 'Hydraulic gas piston mechanism for lifting heavy King and Queen bed mattress frames with ease.',
                'description' => 'Effortlessly transform king and queen beds into spacious concealed storage compartments. Heavy-duty carbon steel scissor arms combined with high-pressure nitrogen gas cylinders provide smooth lifting assistance.',
                'features' => json_encode([
                    'Pair of heavy gauge 4mm steel pivot frames with corrosion-resistant powder coat',
                    'High-capacity nitrogen gas struts: 1200N to 1500N ratings',
                    'Locks securely in raised position for safe access',
                    'Suitable for heavy spring, coir, and memory foam mattresses',
                ]),
                'applications' => 'Master bedroom king-size hydraulic storage beds, hotel bed bases.',
                'installation' => 'Bolt frame to internal wooden bed carcass. Mount upper flange to mattress support slat frame.',
                'featured' => false,
                'specs' => [
                    'Strut Rating' => '1500 N (150 kg force per strut)',
                    'Material' => '4 mm Heavy Gauge Cold Rolled Steel',
                    'Finish' => 'Matte Black Epoxy Powder Coating',
                    'Bed Sizes' => 'King (6x6.5 ft) and Queen (5x6.5 ft)',
                ],
            ],
            [
                'category_slug' => 'bathroom-sanitary-fittings',
                'sub_slug' => 'single-lever-basin-mixers-faucets',
                'brand_slug' => 'jaquar',
                'name' => 'Jaquar Alive Tall Boy Single Lever Basin Mixer',
                'slug' => 'jaquar-alive-tall-boy-single-lever-basin-mixer',
                'sku' => 'LX-JQ-ALV-105',
                'main_image' => '/images/showcase/bath-faucet.svg',
                'short_description' => 'Architectural counter-top basin mixer with ceramic disc cartridge and advanced honeycomb aerator.',
                'description' => 'The Jaquar Alive collection reflects fluid organic contours and supreme water efficiency. Cast in dezincification-resistant solid brass with 10-micron chrome plating, it provides smooth temperature mixing and lime-resistant aerated flow.',
                'features' => json_encode([
                    'Cast virgin brass body with mirror-shine chrome plating',
                    'Ceramic disc cartridge tested up to 500,000 operational cycles',
                    'Integrated Neoperl honeycomb aerator with anti-clogging screen',
                    'Hot and cold water braided stainless steel connecting hoses included',
                    '10 Years manufacturer warranty from Jaquar',
                ]),
                'applications' => 'Vessel counter basins, luxury powder rooms, master bathroom vanity counters.',
                'installation' => 'Deck mounted single hole installation with 35mm cut-out. Hand-tighten stainless steel flexible braided inlet hoses.',
                'featured' => true,
                'specs' => [
                    'Body Material' => 'High Purity Virgin Brass (CuZn39Pb3)',
                    'Cartridge Size' => '35 mm Ceramic Disc Cartridge',
                    'Finish' => 'Chrome Plating (Nickel > 10 micron, Chrome > 0.3 micron)',
                    'Aerator' => 'Neoperl Integrated Flow Regulator (6 LPM)',
                    'Working Pressure' => '0.5 bar to 5.0 bar',
                ],
            ],
            [
                'category_slug' => 'bathroom-sanitary-fittings',
                'sub_slug' => 'overhead-rain-showers-hand-showers',
                'brand_slug' => 'kohler',
                'name' => 'Kohler Statement 300mm Round Luxury Rainhead',
                'slug' => 'kohler-statement-300mm-luxury-rainhead',
                'sku' => 'LX-KH-STM-300',
                'main_image' => '/images/showcase/rain-shower.svg',
                'short_description' => 'Ultra-slim stainless steel overhead deluge rain shower with Katalyst air-induction technology.',
                'description' => 'Immerse yourself in a luxurious rainfall experience. Kohler Katalyst technology infuses 2 liters of air per minute into the water droplets, producing larger, fuller, and warmer raindrops that hold heat longer.',
                'features' => json_encode([
                    'Katalyst air-induction technology for decadent, full droplet coverage',
                    'MasterClean sprayface with easy-to-clean silicone nozzles that resist mineral buildup',
                    'Ultra-slim low profile design in Vibrant Brushed Moderne Brass / Polished Chrome',
                    'Optimized sprayface for complete body envelopment',
                ]),
                'applications' => 'Master shower enclosures, luxury residential suites, high-end spa bathrooms.',
                'installation' => 'G 1/2-inch thread connection compatible with ceiling-mounted or wall-mounted shower arms.',
                'featured' => true,
                'specs' => [
                    'Diameter' => '300 mm (12 Inches)',
                    'Material' => 'Solid SS 304 with PVD Finish',
                    'Nozzle Technology' => 'Easy-Clean Translucent Silicone Nozzles',
                    'Flow Rate' => '9.5 LPM with Pressure Compensating Flow Control',
                ],
            ],
            [
                'category_slug' => 'plumbing-pipe-lines',
                'sub_slug' => 'cpvc-hot-cold-water-pipes-fittings',
                'brand_slug' => 'astral-pipes',
                'name' => 'Astral Propex CPVC SDR-11 Potable Water Pipe Line',
                'slug' => 'astral-propex-cpvc-sdr-11-pipe-line',
                'sku' => 'LX-AS-CPVC-SDR11',
                'main_image' => '/images/showcase/cpvc-pipes.svg',
                'short_description' => 'NSF-61 certified lead-free chlorinated polyvinyl chloride pipes for domestic hot & cold water lines.',
                'description' => 'Astral CPVC Pro is manufactured from specialty Chlorinated Polyvinyl Chloride compound meeting ASTM D2846 specifications. It resists bacterial growth, does not corrode or scale, and safely conveys hot water up to 93°C under high system pressure.',
                'features' => json_encode([
                    'NSF-61 certified 100% lead-free and non-toxic for drinking water',
                    'Withstands temperatures up to 93°C (200°F)',
                    'Chemical resistance ensures zero rust, calcification, or scale formation',
                    'Solvent cement cold welding ensures permanent leak-proof joints',
                    'Tested to withstand working pressure up to 28.1 kg/cm² at 23°C',
                ]),
                'applications' => 'Concealed bathroom plumbing pipelines, solar water heater connections, residential riser lines.',
                'installation' => 'Cut square with pipe cutter. Deburr inside and outside. Apply Astral CPVC primer and medium heavy-bodied orange solvent cement. Insert and give 90-degree twist.',
                'featured' => true,
                'specs' => [
                    'Standard' => 'ASTM D2846 & IS:15778',
                    'Pressure Class' => 'SDR 11 (Class 1) & SDR 13.5 (Class 2)',
                    'Sizes Available' => '1/2" to 2" (15mm to 50mm)',
                    'Max Temperature' => '93°C Continuous Hot Water Service',
                    'Certification' => 'NSF International, BIS Certified',
                ],
            ],
            [
                'category_slug' => 'plumbing-pipe-lines',
                'sub_slug' => 'swr-soil-waste-rainwater-drainage-pipes',
                'brand_slug' => 'ashirvad-pipes',
                'name' => 'Ashirvad Ring-Fit SWR Soil & Rainwater Drainage Line',
                'slug' => 'ashirvad-ring-fit-swr-drainage-line',
                'sku' => 'LX-AV-SWR-110',
                'main_image' => '/images/showcase/swr-drainage.svg',
                'short_description' => 'UV stabilized integrated rubber ring joint SWR drainage pipe for zero-leak wastewater discharge.',
                'description' => 'Ashirvad SWR drainage system features pre-fitted EPDM rubber sealing rings that accommodate thermal expansion and ground settlement without joint failure. Immune to household chemicals and bacteria, it ensures silent, hygienic gravity wastewater discharge.',
                'features' => json_encode([
                    'Ring-Fit joint technology eliminates messy solvent cementing at high altitudes',
                    'EPDM rubber ring with reinforced plastic retainer ring prevents dislodgement',
                    '100% UV stabilized for external outdoor shaft installations',
                    'Mirror-smooth mirror bore prevents clogging and biological fouling',
                    'Conforms strictly to IS:13592 Type A & Type B standards',
                ]),
                'applications' => 'High-rise residential drainage shafts, rainwater harvesting downspouts, toilet soil waste stacks.',
                'installation' => 'Chamfer spigot end at 15 degrees. Clean socket groove and EPDM ring. Apply Ashirvad pipe lubricant to spigot and push into socket up to insertion mark.',
                'featured' => false,
                'specs' => [
                    'Standard' => 'IS:13592 (Type A for rainwater, Type B for soil & waste)',
                    'Diameters' => '75 mm, 110 mm, 160 mm',
                    'Jointing System' => 'Yellow EPDM Rubber Ring Fit',
                    'UV Resistance' => 'High Performance UV Stabilized Polyvinyl',
                ],
            ],
        ];

        foreach ($productsData as $pData) {
            $cat = $categoryMap[$pData['category_slug']] ?? null;
            $sub = $subcategoryMap[$pData['category_slug'] . '::' . $pData['sub_slug']] ?? null;
            $brand = $brandMap[$pData['brand_slug']] ?? null;

            if ($cat) {
                $product = Product::create([
                    'category_id' => $cat->id,
                    'subcategory_id' => $sub ? $sub->id : null,
                    'brand_id' => $brand ? $brand->id : null,
                    'name' => $pData['name'],
                    'slug' => $pData['slug'],
                    'sku' => $pData['sku'],
                    'main_image' => $pData['main_image'],
                    'short_description' => $pData['short_description'],
                    'description' => $pData['description'],
                    'features' => $pData['features'],
                    'applications' => $pData['applications'],
                    'installation' => $pData['installation'],
                    'featured' => $pData['featured'],
                    'status' => true,
                ]);

                // Specifications
                foreach ($pData['specs'] as $k => $v) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key' => $k,
                        'spec_value' => $v,
                    ]);
                }

                // Add secondary showcase images
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $pData['main_image'],
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
            }
        }

        // 6. Services
        $servicesData = [
            [
                'title' => 'Interior Hardware Supply',
                'slug' => 'interior-hardware-supply',
                'short_description' => 'Comprehensive inventory of authentic hardware fittings for high-end residential and commercial interiors.',
                'description' => 'Laxmi Hardware is the trusted direct distributor for global leaders including Hettich, Hafele, Blum, Godrej, and Ebco. We supply everything from soft-close hinges, precision drawer runners, architectural handles, to specialized furniture fasteners with guaranteed authenticity.',
                'image' => '/images/services/hardware-supply.svg',
                'icon' => 'bi-tools',
                'features' => json_encode([
                    '100% Genuine Certified Hardware from Hettich, Hafele & Blum',
                    'Complete stock availability for immediate dispatch',
                    'Technical guidance on load capacities and installation templates',
                    'Wholesale and project contractor pricing packages',
                ]),
                'sort_order' => 1,
            ],
            [
                'title' => 'Kitchen Hardware Solutions',
                'slug' => 'kitchen-hardware-solutions',
                'short_description' => 'Modular kitchen fittings, tandem drawer systems, corner magic units, and tall pantry storage.',
                'description' => 'We specialize in turning modular kitchens into ergonomic, clutter-free spaces. Browse our wide range of slim-wall tandem boxes, under-sink drawer systems, spice pullouts, cutlery dividers, and magic corners engineered for durability.',
                'image' => '/images/services/kitchen-solutions.svg',
                'icon' => 'bi-cup-hot',
                'features' => json_encode([
                    'Slim double-wall tandem drawers with lifetime soft-close',
                    'Heavy-duty SS 304 wire baskets and organizers',
                    'Corner carousels and pull-out pantry tall units',
                    'Anti-fingerprint profile handles and aluminium edge trims',
                ]),
                'sort_order' => 2,
            ],
            [
                'title' => 'Wardrobe Hardware',
                'slug' => 'wardrobe-hardware',
                'short_description' => 'Advanced sliding door mechanisms, hydraulic wardrobe lifts, and pull-out organizer accessories.',
                'description' => 'Create floor-to-ceiling luxury wardrobes with smooth sliding door gear, concealed damper systems, pull-out trouser racks, tie/belt holders, and integrated LED motion sensor hanging rods.',
                'image' => '/images/services/wardrobe-hardware.svg',
                'icon' => 'bi-door-closed',
                'features' => json_encode([
                    'Top-hung and bottom-running wardrobe sliding door gear',
                    'Hydraulic pull-down lifts for high ceiling accessibility',
                    'Jewelry organizers, tie racks & velvet pull-out drawers',
                    'Integrated wardrobe LED aluminum profiles and switches',
                ]),
                'sort_order' => 3,
            ],
            [
                'title' => 'Curtain Fittings',
                'slug' => 'curtain-fittings',
                'short_description' => 'Smart motorized curtain tracks, decorative rods, silent gliders, and architectural finials.',
                'description' => 'Outfit residential villas, double-height living spaces, and hospitality projects with smart motorized curtain systems. Compatible with home automation, RF remotes, and smartphones.',
                'image' => '/images/services/curtain-fittings.svg',
                'icon' => 'bi-window-split',
                'features' => json_encode([
                    'Whisper-quiet motorized tracks compatible with smart automation',
                    'Heavy-duty architectural curtain rods and custom finials',
                    'Ripple fold and wave drapery glider tracks',
                    'Custom track bending and ceiling recess profiles',
                ]),
                'sort_order' => 4,
            ],
            [
                'title' => 'Plywood & Boards',
                'slug' => 'plywood-boards',
                'short_description' => 'Direct distribution of IS:710 Marine Plywood, Commercial MR Plywood, calibrated MDF & HDF boards.',
                'description' => 'We maintain verified stock of premium calibrated plywood brands like Greenply and CenturyPly. Certified boiling waterproof (BWP) marine ply for wet areas and high-density boards for smooth paint finishes.',
                'image' => '/images/services/plywood-boards.svg',
                'icon' => 'bi-layers',
                'features' => json_encode([
                    'Genuine IS:710 certified BWP Marine Grade Plywood',
                    '100% borer and termite resistant chemically treated boards',
                    'Calibrated thickness for zero surface waviness',
                    'Pre-laminated MDF, HDF, and pine block boards',
                ]),
                'sort_order' => 5,
            ],
            [
                'title' => 'Project Supply',
                'slug' => 'project-supply',
                'short_description' => 'Turnkey bulk hardware supply packages for architects, interior designers, and real estate developers.',
                'description' => 'We handle complete bill of quantities (BOQ) estimation, brand specification mapping, bulk deliveries, and site-level sample verification for residential towers, hotels, and commercial buildings.',
                'image' => '/images/services/project-supply.svg',
                'icon' => 'bi-building-gear',
                'features' => json_encode([
                    'BOQ analysis and cost optimization without compromising quality',
                    'Staged delivery matching project construction timelines',
                    'Dedicated project manager and direct brand warranties',
                    'Master keying and customized architectural handle sets',
                ]),
                'sort_order' => 6,
            ],
        ];

        foreach ($servicesData as $sData) {
            Service::create($sData);
        }

        // 7. Projects
        $projectsData = [
            [
                'title' => 'Sky Villa Luxury Penthouse Interiors',
                'slug' => 'sky-villa-luxury-penthouse-interiors',
                'category' => 'Residential',
                'location' => 'Vesu, Surat',
                'client_type' => 'Private Luxury Residence',
                'duration' => '4 Months',
                'materials' => json_encode(['Hettich Sensys Hinges', 'Blum Legrabox Drawers', 'Greenply Marine Ply', 'Hafele Smart Lock']),
                'featured_image' => '/images/projects/sky-villa.svg',
                'description' => 'Complete interior hardware fit-out for an 8,500 sq.ft duplex sky villa. All modular kitchens, walk-in closets, and concealed flush doors were outfitted with Hettich and Blum soft-close fittings.',
            ],
            [
                'title' => 'Platinum Corporate Towers Headquarters',
                'slug' => 'platinum-corporate-towers-headquarters',
                'category' => 'Commercial',
                'location' => 'Ring Road, Surat',
                'client_type' => 'Corporate Office Building',
                'duration' => '6 Months',
                'materials' => json_encode(['Ebco Heavy Duty Slides', 'Dorset Mortise Locks', 'CenturyPly Calibrated Ply', 'Glass Patch Fittings']),
                'featured_image' => '/images/projects/corporate-hq.svg',
                'description' => 'Turnkey architectural hardware supply for 6 floors of corporate office space. Included access-controlled door handles, fire exit panic hardware, and heavy-duty credenza fittings.',
            ],
            [
                'title' => 'Contemporary Chef\'s Modular Kitchen',
                'slug' => 'contemporary-chefs-modular-kitchen',
                'category' => 'Kitchen',
                'location' => 'Piplod, Surat',
                'client_type' => 'Gourmet Culinary Kitchen',
                'duration' => '3 Weeks',
                'materials' => json_encode(['Blum LEGRABOX Orion Gray', 'Hafele Magic Corner II', 'Tall Pantry Lifts', 'G-Profile Handles']),
                'featured_image' => '/images/projects/chef-kitchen.svg',
                'description' => 'Custom handle-less modular kitchen featuring touch-open electronic Blum Aventos lift systems and heavy-capacity tandem drawers.',
            ],
            [
                'title' => 'Walk-In Master Wardrobe & Vanity Suite',
                'slug' => 'walk-in-master-wardrobe-vanity-suite',
                'category' => 'Wardrobe',
                'location' => 'Athwa Lines, Surat',
                'client_type' => 'Master Bedroom Suite',
                'duration' => '1 Month',
                'materials' => json_encode(['Ebco Hydraulic Wardrobe Lifts', 'Hafele Soft-Close Sliding Gear', 'LED Profile Rods', 'Jewelry Inserts']),
                'featured_image' => '/images/projects/master-wardrobe.svg',
                'description' => 'Seamless floor-to-ceiling glass and wood sliding wardrobes with integrated pull-down lifts, illuminated garment rails, and velvet accessory drawers.',
            ],
            [
                'title' => 'Minimalist Minimal Living & Partition Wall',
                'slug' => 'minimalist-minimal-living-partition-wall',
                'category' => 'Living Room',
                'location' => 'Adajan, Surat',
                'client_type' => 'Residential Apartment',
                'duration' => '2 Weeks',
                'materials' => json_encode(['Concealed 3D Hinges', 'Magnetic Door Latches', 'Ebco Pocket Door System']),
                'featured_image' => '/images/projects/minimalist-penthouse.svg',
                'description' => 'Clean architectural hardware execution with completely invisible concealed hinges on hidden doors flush with wall panelling.',
            ],
            [
                'title' => 'Heritage Boutique Resort & Spa Suites',
                'slug' => 'heritage-boutique-resort-spa-suites',
                'category' => 'Commercial',
                'location' => 'Daman Coastline',
                'client_type' => 'Hospitality Resort',
                'duration' => '5 Months',
                'materials' => json_encode(['Greenply Platinum IS:710 Marine Ply', 'Godrej Biometric Locks', 'Brass Mortise Levers']),
                'featured_image' => '/images/projects/resort-suites.svg',
                'description' => 'Marine-grade hardware and BWP plywood installation resisting high coastal salinity and humidity across 32 luxury guest suites.',
            ],
        ];

        foreach ($projectsData as $pData) {
            $proj = Project::create($pData);
            ProjectImage::create([
                'project_id' => $proj->id,
                'image_path' => $proj->featured_image,
                'caption' => $proj->title . ' - Primary View',
                'sort_order' => 1,
            ]);
        }

        // 8. Gallery
        $galleryData = [
            ['title' => 'Soft-Close Hinge Mechanism in High-Gloss Kitchen', 'category' => 'Hardware', 'image_path' => '/images/showcase/hinge.svg'],
            ['title' => 'Double-Wall Tandem Box Slim Drawer in Orion Gray', 'category' => 'Kitchens', 'image_path' => '/images/showcase/tandem.svg'],
            ['title' => 'Floor-to-Ceiling Sliding Glass Wardrobe Installation', 'category' => 'Wardrobes', 'image_path' => '/images/projects/master-wardrobe.svg'],
            ['title' => 'Smart Home Automated Motorized Curtain Track in Action', 'category' => 'Curtain Installations', 'image_path' => '/images/showcase/curtain-track.svg'],
            ['title' => 'Boiling Water Proof BWP Marine Plywood Stock', 'category' => 'Plywood', 'image_path' => '/images/showcase/marine-ply.svg'],
            ['title' => 'Biometric Smart Digital Door Lock with PIN Keypad', 'category' => 'Hardware', 'image_path' => '/images/showcase/smart-lock.svg'],
            ['title' => 'Concealed Kitchen Edge Profile Handles on Dark Oak Finish', 'category' => 'Accessories', 'image_path' => '/images/showcase/profile-handle.svg'],
            ['title' => 'Ergonomic Pull-Down Wardrobe Lift for Upper Storage', 'category' => 'Wardrobes', 'image_path' => '/images/showcase/wardrobe-lift.svg'],
            ['title' => 'Swivelling Blind Corner Magic Unit with Non-Slip Trays', 'category' => 'Kitchens', 'image_path' => '/images/showcase/corner-carousel.svg'],
            ['title' => 'Architectural PVD Brass Mortise Handle on Teak Wood Door', 'category' => 'Interior Projects', 'image_path' => '/images/showcase/mortise-handle.svg'],
            ['title' => 'Pneumatic Hydraulic Bed Storage Frame Mechanism', 'category' => 'Hardware', 'image_path' => '/images/showcase/bed-lift.svg'],
            ['title' => 'Industrial D3 Waterproof Polyvinyl Wood Adhesive Containers', 'category' => 'Accessories', 'image_path' => '/images/showcase/adhesive.svg'],
        ];

        foreach ($galleryData as $idx => $gData) {
            Gallery::create([
                'title' => $gData['title'],
                'category' => $gData['category'],
                'image_path' => $gData['image_path'],
                'description' => 'Precision installation photograph showcasing Laxmi Hardware supplied materials.',
                'status' => true,
                'sort_order' => $idx + 1,
            ]);
        }

        // 9. Blog Categories & Posts
        $blogCategories = ['Interior Design', 'Hardware Guide', 'Kitchen', 'Wardrobe', 'Plywood', 'Curtain Fittings', 'Interior Tips'];
        $bCatMap = [];
        foreach ($blogCategories as $bCatName) {
            $bCat = BlogCategory::create(['name' => $bCatName, 'slug' => Str::slug($bCatName)]);
            $bCatMap[$bCatName] = $bCat;
        }

        $blogPostsData = [
            [
                'category' => 'Hardware Guide',
                'title' => 'The Complete Architect\'s Guide to Soft-Close Cabinet Hinges',
                'slug' => 'complete-architects-guide-to-soft-close-cabinet-hinges',
                'featured_image' => '/images/blog/hinge-guide.svg',
                'excerpt' => 'Understand the critical differences between full overlay, half overlay, and inset concealed hinges before specifying for luxury cabinetry.',
                'content' => '<p>Concealed hinges, often known as European hinges, form the mechanical backbone of modern cabinet design. When specifying hardware for residential or commercial projects, selecting the appropriate hinge crank and mounting plate makes all the difference between a door that sags and one that performs effortlessly for decades.</p><h3>1. Understanding Overlay Types</h3><p><strong>Full Overlay (0 Crank):</strong> The door completely overlaps the cabinet side frame, leaving only a tiny 1-2mm shadow gap. This is standard in modern frameless modular kitchens.</p><p><strong>Half Overlay (Crank 9.5mm):</strong> Used when two adjacent doors share a single central cabinet divider. Each door covers half of the divider thickness.</p><p><strong>Inset / Embedded (Crank 16mm):</strong> The door sits completely recessed flush inside the cabinet carcass aperture. Requires precision alignment and 3D adjustment.</p><h3>2. Why Integrated Silent Buffers Matter</h3><p>Older generation soft-close hinges relied on add-on plastic clip dampeners that frequently snapped or lost oil over time. Modern hinges like the <strong>Hettich Sensys</strong> integrate hydraulic pistons directly inside the hinge cup, ensuring continuous, quiet closure without temperature fluctuation issues.</p>',
                'author' => 'Laxmi Technical Team',
                'published_at' => now()->subDays(5),
            ],
            [
                'category' => 'Plywood',
                'title' => 'Marine Plywood vs Commercial Plywood: What Every Interior Designer Must Know',
                'slug' => 'marine-plywood-vs-commercial-plywood-guide',
                'featured_image' => '/images/blog/plywood-guide.svg',
                'excerpt' => 'Deciphering IS:710 Marine Grade vs IS:303 Commercial MR Grade. Avoid costly water-damage disasters in modular kitchens and bathrooms.',
                'content' => '<p>Plywood is the primary structural foundation of virtually every bespoke interior fit-out in India. However, confusion between Moisture Resistant (MR) grade and Boiling Water Proof (BWP) Marine grade often leads to catastrophic delamination in wet areas.</p><h3>What is IS:303 MR Commercial Plywood?</h3><p>MR grade plywood is bonded with Urea Formaldehyde (UF) resin. While it resists airborne environmental humidity, it is <em>not waterproof</em>. Continuous water immersion or persistent leaks will weaken the resin bond, causing bubbling and veneer separation.</p><h3>What is IS:710 BWP Marine Plywood?</h3><p>True marine plywood uses 100% undiluted Phenol Formaldehyde synthetic resin. It undergoes the mandatory 72-hour boiling water test at 100°C without core unbonding. For kitchen sink base units, bathroom vanities, and balconies, IS:710 Marine Grade like <strong>Greenply Platinum</strong> or <strong>CenturyPly Club Prime</strong> is essential.</p>',
                'author' => 'Senior Wood Technologist',
                'published_at' => now()->subDays(12),
            ],
            [
                'category' => 'Kitchen',
                'title' => 'Maximizing Dead Kitchen Corners: Magic Corner Units vs Lazy Susans',
                'slug' => 'maximizing-dead-kitchen-corners-magic-units-vs-lazy-susans',
                'featured_image' => '/images/blog/kitchen-storage.svg',
                'excerpt' => 'Transform frustrating L-shaped kitchen dead zones into organized, easily accessible storage with modern hardware mechanisms.',
                'content' => '<p>The corner intersection of an L-shaped or U-shaped modular kitchen has traditionally been notorious for wasted space and difficult reach. Today, precision engineering from brands like Hafele and Ebco provides intelligent solutions that bring items stored at the very back directly into the chef\'s hands.</p><h3>Magic Corner Pull-Outs</h3><p>When the corner cabinet door is pulled open, the front set of chrome wire or melamine baskets slides out smoothly, while simultaneously pulling the rear set of baskets forward into the accessible opening. This delivers 100% space utilization with soft-closing ease.</p>',
                'author' => 'Laxmi Hardware Specialist',
                'published_at' => now()->subDays(18),
            ],
            [
                'category' => 'Interior Tips',
                'title' => 'Keyless Living: How Smart Biometric Locks Are Redefining Modern Home Security',
                'slug' => 'keyless-living-smart-biometric-locks-redefining-security',
                'featured_image' => '/images/blog/smart-locks.svg',
                'excerpt' => 'Explore the safety benefits of 360-degree fingerprint sensors, OTP mobile keys, anti-tamper alarms, and spy-code PIN masking.',
                'content' => '<p>The days of fumbling for physical brass keys in the dark are quickly becoming obsolete. Modern high-security digital smart door locks by Godrej and Hafele combine banking-grade biometric encryption with emergency mechanical bypasses.</p><h3>Top Smart Lock Advantages:</h3><ul><li><strong>360° Fingerprint Recognition:</strong> Unlocks within 0.4 seconds regardless of finger orientation.</li><li><strong>Spy Code Feature:</strong> Enter random decoy numbers before or after your actual PIN to prevent onlookers from guessing your passcode.</li><li><strong>Temporary OTP Guest Access:</strong> Issue one-time codes to domestic staff or visitors without giving away your master code.</li></ul>',
                'author' => 'Security Systems Consultant',
                'published_at' => now()->subDays(25),
            ],
            [
                'category' => 'Wardrobe',
                'title' => 'Sliding Wardrobes: Top Hung vs Bottom Rolling Systems Explained',
                'slug' => 'sliding-wardrobes-top-hung-vs-bottom-rolling-systems',
                'featured_image' => '/images/blog/sliding-wardrobe.svg',
                'excerpt' => 'A comparison of weight distribution, track maintenance, aesthetics, and floor clearances between top-hung and bottom-running sliding door gear.',
                'content' => '<p>Sliding doors provide sleek contemporary aesthetics and save precious floor clearance in compact urban bedrooms. Choosing between top-hung and bottom-rolling systems dictates the structural carcass requirements.</p><p><strong>Top Hung Systems:</strong> The entire weight of the sliding door hangs from a heavy-duty reinforced ceiling track. The floor remains clean without grooves or tripping hazards.</p><p><strong>Bottom Rolling Systems:</strong> Door weight rests on bottom ball-bearing rollers running in an aluminum floor channel. Recommended when wardrobe ceilings cannot bear heavy loads.</p>',
                'author' => 'Interior Wardrobe Engineer',
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($blogPostsData as $bp) {
            $cat = $bCatMap[$bp['category']] ?? $bCatMap['Hardware Guide'];
            BlogPost::create([
                'category_id' => $cat->id,
                'title' => $bp['title'],
                'slug' => $bp['slug'],
                'featured_image' => $bp['featured_image'],
                'excerpt' => $bp['excerpt'],
                'content' => $bp['content'],
                'author' => $bp['author'],
                'seo_title' => $bp['title'] . ' | Laxmi Hardware Knowledge Hub',
                'seo_description' => $bp['excerpt'],
                'status' => true,
                'published_at' => $bp['published_at'],
            ]);
        }

        // 10. Testimonials
        $testimonialsData = [
            [
                'name' => 'Ar. Rajesh Mehta',
                'company' => 'Studio Vistara Architects',
                'designation' => 'Principal Architect',
                'photo' => null,
                'review' => 'Laxmi Hardware has been our trusted hardware partner for over 8 years. Their product knowledge, access to 100% genuine Hettich & Blum stock, and timely project deliveries make them indispensable for our luxury residential commissions.',
                'rating' => 5,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pooja Sanghavi',
                'company' => 'Elements Modular Spaces',
                'designation' => 'Modular Kitchen Specialist',
                'photo' => null,
                'review' => 'We source all our tandem drawer systems, lift mechanisms, and profile handles exclusively from Laxmi Hardware. Their showroom staff understands technical installation details and always offers the best options.',
                'rating' => 5,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Manoj Patel',
                'company' => 'Patel Builders & Turnkey Interiors',
                'designation' => 'Managing Director',
                'photo' => null,
                'review' => 'For commercial towers and multi-unit residences, getting consistent IS:710 Greenply marine ply and Dorset locks at competitive contractor pricing is critical. Laxmi Hardware delivers on every commitment.',
                'rating' => 5,
                'status' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Vikram Sharma',
                'company' => 'Private Villa Owner',
                'designation' => 'Homeowner, Surat',
                'photo' => null,
                'review' => 'Visited their showroom while renovating our 4BHK bungalow. Their team walked us through every hinge, motorized curtain track, and smart door lock option. Truly the best hardware showcase under one roof!',
                'rating' => 5,
                'status' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonialsData as $tData) {
            Testimonial::create($tData);
        }
    }
}
