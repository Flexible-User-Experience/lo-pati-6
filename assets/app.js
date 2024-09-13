import './bootstrap.js';
import { Tooltip } from 'bootstrap';
import Trix from 'trix';

// required CSSs
import('icheck-bootstrap/icheck-bootstrap.min.css');
import('trix/dist/trix.min.css');

// enable Bootstrap CSS behaviours
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle-second="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));

// search engine autofocus
document.addEventListener('DOMContentLoaded', function () {
    let searchOffcanvas = document.getElementById('offcanvasSearch');
    if (searchOffcanvas) {
        searchOffcanvas.addEventListener('shown.bs.offcanvas', function () {
            document.getElementById('inputOffcanvasSearchField').focus();
        });
        searchOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
            let inputNode = document.getElementById('inputOffcanvasSearchField');
            inputNode.value = '';
        });
    }
});

// Trix WYSIWYG editor
document.addEventListener('trix-before-initialize', () => {
    // Change Trix.config if you need
});
