<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@symfony/ux-live-component' => [
        'path' => './vendor/symfony/ux-live-component/assets/dist/live_controller.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.6',
    ],
    '@kurkle/color' => [
        'version' => '0.3.2',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    'chart.js' => [
        'version' => '4.4.4',
    ],
    'pdfjs-dist/build/pdf.min.mjs' => [
        'version' => '4.6.82',
    ],
    'pdfjs-dist/build/pdf.worker.min.mjs' => [
        'version' => '4.6.82',
    ],
    'stimulus-use' => [
        'version' => '0.52.2',
    ],
    'icheck-bootstrap/icheck-bootstrap.min.css' => [
        'version' => '3.0.1',
        'type' => 'css',
    ],
    'stimulus-autocomplete' => [
        'version' => '3.1.0',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
];
