import CreateForm from './components/cp/core/CreateForm';
import Listing from './components/cp/forms/Listing';
import FormPublishForm from './components/cp/forms/PublishForm';
import FieldsBuilder from './components/cp/fields/Builder';
import NotificationsEditForm from './components/cp/notifications/EditForm';

Statamic.booting(() => {
    Statamic.component('advanced-forms-core-create', CreateForm);

    Statamic.component('advanced-forms-listing', Listing);
    Statamic.component('advanced-forms-edit-form', FormPublishForm);

    Statamic.component('advanced-forms-fields-builder', FieldsBuilder);

    Statamic.component('advanced-forms-notification-edit-form', NotificationsEditForm);
});
