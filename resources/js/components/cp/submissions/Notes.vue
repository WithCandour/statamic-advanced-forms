<template>
    <div class="card">
        <stack name="feed-notes" v-if="isFeedNotesOpen" @closed="isFeedNotesOpen = false">
            <div class="card flex-col h-full">
                <h1 class="mb-2">Feed Notes</h1>
                <div class="grow overflow-y-scroll">
                    <advanced-forms-submission-note
                        v-for="note in feedNotes"
                        :key="note.id"
                        :title="note.feed.name"
                        :note="note.note"
                        :type="note.type"
                        :date="note.date"
                    ></advanced-forms-submission-note>
                </div>
            </div>
        </stack>
        <stack name="notification-notes" v-if="isNotificationNotesOpen" @closed="isNotificationNotesOpen = false">
            <div class="card flex-col h-full">
                <h1 class="mb-2">Notification Notes</h1>
                <div class="grow overflow-y-scroll">
                    <advanced-forms-submission-note
                        v-for="note in notificationNotes"
                        :key="note.id"
                        :title="note.notification.name"
                        :note="note.note"
                        :type="note.type"
                        :date="note.date"
                    ></advanced-forms-submission-note>
                </div>
            </div>
        </stack>
        <div class="divide-y">
            <div class="flex items-center pb-2">
            <div class="w-full">
                <h3>Feed Notes</h3>
                <div class="help-block m-0">
                    <p class="m-0">View any notes that were created as part of the external feeds configured for this form.</p>
                </div>
            </div>
            <button class="btn" @click="isFeedNotesOpen = true">View</button>
        </div>
        <div class="flex items-center pt-2">
            <div class="w-full">
                <h3>Notification Notes</h3>
                <div class="help-block m-0">
                    <p class="m-0">View any notes that were created as part of the notifications configured for this form.</p>
                </div>
            </div>
            <button class="btn" @click="isNotificationNotesOpen = true">View</button>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'feedNotes',
        'notificationNotes',
    ],

    data() {
        return {
            isFeedNotesOpen: false,
            isNotificationNotesOpen: false,
        }
    },
}
</script>
