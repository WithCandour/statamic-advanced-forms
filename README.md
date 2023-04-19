# Statamic Advanced Forms
Juice up your forms with this Statamic addon.

## Features

### Field editor
The advanced forms field editor offers all of the flexibility of the standard form blueprint builder with the addition of pagination which can be used for your longer forms.

### Advanced notifications
Build email notifications to get sent when your form is successfully submitted and apply conditional logic to narrow down which emails should be send to which addresses. Out of the box the addon allows you to:
- Determine which days to send a given notification
- Use the current time to determine if a notification is to be sent (i.e. out of hours support emails)
- Send a notification based on the value of a field in the submission

Custom notification conditions can also be registered if you need further control.

Notification events also get logged in the database so you can see if a notification is failing to send.

### External feeds
Configure your form submissions to be automatically sent to external feeds (think newsletter signup forms), and allow CMS users to map fields from the submission to third-party fields.

For developers, this addon gives you the ability to build your own feed types to hook into any third-party system and report back to the CMS (via notes).