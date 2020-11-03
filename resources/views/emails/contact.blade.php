@component('mail::message')
# You have a new contact!

You can find their information bellow:
- **Name:** {{$contact->full_name}}
- **Email:** <{{ $contact->email }}>
@isset($contact->phone)
- **Phone:** {{$contact->phone}}
@endisset
- **Message:** {{$contact->message}}
@endcomponent
