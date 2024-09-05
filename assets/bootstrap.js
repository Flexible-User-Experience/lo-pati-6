import { startStimulusApp } from '@symfony/stimulus-bundle';
import { Autocomplete } from 'stimulus-autocomplete'

const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register('autocomplete', Autocomplete);
