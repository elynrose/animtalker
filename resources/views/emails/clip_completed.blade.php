@component('mail::message')
# Clip Completed

Hello,

Your clip has been successfully completed. Here are the details:

- **Clip Name:** {{ $clip->character->name }}
- **Clip Status:** {{ $clip->status }}

Thank you for using our service!

Regards,
The AnimTalker Team
@endcomponent