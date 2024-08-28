import './bootstrap.js';
import { Tooltip } from 'bootstrap';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle-second="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));
