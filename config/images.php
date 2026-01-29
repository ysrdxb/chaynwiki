<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Optimization Settings
    |--------------------------------------------------------------------------
    |
    | These settings control how images are handled in the application.
    |
    */

    // Maximum image dimensions for uploads
    'max_width' => 1920,
    'max_height' => 1080,

    // Thumbnail sizes
    'thumbnails' => [
        'small' => [
            'width' => 150,
            'height' => 150,
        ],
        'medium' => [
            'width' => 400,
            'height' => 300,
        ],
        'large' => [
            'width' => 800,
            'height' => 600,
        ],
    ],

    // Default image quality (1-100)
    'quality' => 80,

    // Allowed image formats
    'allowed_formats' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],

    // Convert all images to WebP for better compression
    'convert_to_webp' => true,

    // Lazy loading settings
    'lazy_loading' => [
        'enabled' => true,
        'placeholder' => 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1 1\'%3E%3Crect fill=\'%23111827\' width=\'1\' height=\'1\'/%3E%3C/svg%3E',
    ],

    // Responsive image srcset breakpoints
    'srcset_breakpoints' => [320, 640, 768, 1024, 1280, 1536],
];
