import Listing from './components/cp/forms/Listing';

Statamic.booting(() => {
    Statamic.component('advanced-forms-listing', Listing);
});
