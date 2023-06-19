import CreateForm from './components/cp/core/CreateForm';
import Listing from './components/cp/forms/Listing';
import FormPublishForm from './components/cp/forms/PublishForm';
import FieldsBuilder from './components/cp/fields/Builder';
import NotificationsEditForm from './components/cp/notifications/EditForm';
import NotificationsListing from './components/cp/notifications/Listing';
import SubmissionsListing from './components/cp/submissions/Listing';
import FeedsCreateForm from './components/cp/feeds/CreateForm';
import FeedsEditForm from './components/cp/feeds/EditForm';
import FeedsListing from './components/cp/feeds/Listing';
import FeedCreateButton from './components/cp/feeds/CreateButton';
import SubmissionNotes from './components/cp/submissions/Notes';
import SubmissionNote from './components/cp/submissions/Note';
import AnonymousAssetsFieldtype from './components/cp/fieldtypes/AnonymousAssetsFieldtype';
import AddressLookupFieldtype from './components/cp/fieldtypes/AddressLookupFieldtype';

Statamic.booting(() => {
    // CP views
    Statamic.component('advanced-forms-core-create', CreateForm);
    Statamic.component('advanced-forms-listing', Listing);
    Statamic.component('advanced-forms-edit-form', FormPublishForm);
    Statamic.component('advanced-forms-fields-builder', FieldsBuilder);
    Statamic.component('advanced-forms-notification-edit-form', NotificationsEditForm);
    Statamic.component('advanced-forms-notifications-listing', NotificationsListing);
    Statamic.component('advanced-forms-submissions-listing', SubmissionsListing);
    Statamic.component('advanced-forms-feed-create-form', FeedsCreateForm);
    Statamic.component('advanced-forms-feed-edit-form', FeedsEditForm);
    Statamic.component('advanced-forms-feeds-listing', FeedsListing);
    Statamic.component('advanced-forms-create-button', FeedCreateButton);
    Statamic.component('advanced-forms-submission-notes', SubmissionNotes);
    Statamic.component('advanced-forms-submission-note', SubmissionNote);

    // Fieldtypes
    Statamic.$components.register('anonymous_assets-fieldtype', AnonymousAssetsFieldtype);
    Statamic.$components.register('address_lookup-fieldtype', AddressLookupFieldtype);
});
