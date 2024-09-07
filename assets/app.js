import './bootstrap.js';
import { Tooltip } from 'bootstrap';

import('icheck-bootstrap/icheck-bootstrap.min.css');

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle-second="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));
