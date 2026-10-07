<x-mail::message>
# New Contact Form Submission

You have received a new contact form submission from your website.

**Name:** {{ $formData['fullName'] }}  
**Email:** {{ $formData['email'] }}  
**Phone:** {{ $formData['phone'] }}  
**Subject:** {{ $formData['subject'] }}  
**Submitted:** {{ $formData['submitted_at'] }}  
**IP Address:** {{ $formData['ip_address'] ?? 'Unavailable' }}

## Message:
{{ $formData['message'] }}

<x-mail::button :url="'mailto:' . $formData['email']">
Reply to {{ $formData['fullName'] }}
</x-mail::button>

Thanks,<br>
Sandalwood Properties Website
</x-mail::message>
