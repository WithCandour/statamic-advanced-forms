import Listing from './components/cp/forms/Listing';
import FormPublishForm from './components/cp/forms/PublishForm';

Statamic.booting(() => {
    Statamic.component('advanced-forms-listing', Listing);
    Statamic.component('advanced-forms-edit-form', FormPublishForm);
});
