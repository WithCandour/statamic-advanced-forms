import Listing from './components/cp/forms/Listing';
import FormPublishForm from './components/cp/forms/PublishForm';
import FieldsBuilder from './components/cp/fields/Builder';

Statamic.booting(() => {
    Statamic.component('advanced-forms-listing', Listing);
    Statamic.component('advanced-forms-edit-form', FormPublishForm);

    Statamic.component('advanced-forms-fields-builder', FieldsBuilder);
});
