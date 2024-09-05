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
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    '@kurkle/color' => [
        'version' => '0.3.2',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@symfony/ux-live-component' => [
        'path' => './vendor/symfony/ux-live-component/assets/dist/live_controller.js',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    'chart.js' => [
        'version' => '4.4.3',
    ],
    'pdfjs-dist/build/pdf.min.mjs' => [
        'version' => '4.5.136',
    ],
    'pdfjs-dist/build/pdf.worker.min.mjs' => [
        'version' => '4.5.136',
    ],
    'stimulus-use' => [
        'version' => '0.52.2',
    ],
    'file-loader' => [
        'version' => '6.2.0',
    ],
    'loader-utils' => [
        'version' => '2.0.4',
    ],
    'schema-utils' => [
        'version' => '3.3.0',
    ],
    'json5' => [
        'version' => '2.2.3',
    ],
    'big.js' => [
        'version' => '5.2.2',
    ],
    'emojis-list' => [
        'version' => '3.0.0',
    ],
    'ajv' => [
        'version' => '6.12.6',
    ],
    'ajv-keywords' => [
        'version' => '3.5.2',
    ],
    'uri-js' => [
        'version' => '4.4.1',
    ],
    'fast-deep-equal' => [
        'version' => '3.1.3',
    ],
    'json-schema-traverse' => [
        'version' => '0.4.1',
    ],
    'fast-json-stable-stringify' => [
        'version' => '2.1.0',
    ],
    'quill' => [
        'version' => '2.0.2',
    ],
    'lodash-es' => [
        'version' => '4.17.21',
    ],
    'parchment' => [
        'version' => '3.0.0',
    ],
    'quill-delta' => [
        'version' => '5.1.0',
    ],
    'eventemitter3' => [
        'version' => '5.0.1',
    ],
    'fast-diff' => [
        'version' => '1.3.0',
    ],
    'lodash.clonedeep' => [
        'version' => '4.5.0',
    ],
    'lodash.isequal' => [
        'version' => '4.5.0',
    ],
    'quill/dist/quill.snow.css' => [
        'version' => '2.0.2',
        'type' => 'css',
    ],
    'quill/dist/quill.bubble.css' => [
        'version' => '2.0.2',
        'type' => 'css',
    ],
    'axios' => [
        'version' => '1.7.5',
    ],
    'quill2-emoji' => [
        'version' => '0.1.2',
    ],
    'quill2-emoji/dist/style.css' => [
        'version' => '0.1.2',
        'type' => 'css',
    ],
    'quill-resize-image' => [
        'version' => '1.0.5',
    ],
    'icheck-bootstrap/icheck-bootstrap.min.css' => [
        'version' => '3.0.1',
        'type' => 'css',
    ],
    'tom-select' => [
        'version' => '2.3.1',
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.3.1',
        'type' => 'css',
    ],
    'stimulus-autocomplete' => [
        'version' => '3.1.0',
    ],
];
