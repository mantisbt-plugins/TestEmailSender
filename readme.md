# Test Email Sender

MantisBT ships with support for sending out emails via SMTP using the PhpMailer library.
It also implements support for custom email senders via EmailSender plugins. Such plugins
can have any implementation that can submit email messages to any service that handles delivery.

Examples of such emails senders:

- Sendgrid
- Postmark
- Mailgun
- AWS SES
- Any custom service

This sample plugin submits emails to a webhook receiving service.
