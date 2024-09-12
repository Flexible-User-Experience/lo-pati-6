import './bootstrap.js';
import { Tooltip } from 'bootstrap';

// required CSSs
import('icheck-bootstrap/icheck-bootstrap.min.css');
import('quill/dist/quill.snow.css');

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
