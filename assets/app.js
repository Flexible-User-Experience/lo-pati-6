import './bootstrap.js';
import { Tooltip } from 'bootstrap';
import('icheck-bootstrap/icheck-bootstrap.min.css');

// Enable Bootstrap CSS behaviours
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle-second="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));

// Search engine autofocus
let searchOffcanvas = document.getElementById('offcanvasSearch');
searchOffcanvas.addEventListener('shown.bs.offcanvas', function () {
    document.getElementById('inputOffcanvasSearchField').focus();
});
searchOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
    let inputNode = document.getElementById('inputOffcanvasSearchField');
    inputNode.value = '';
});
