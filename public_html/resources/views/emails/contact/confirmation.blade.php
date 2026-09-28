<x-mail::message>
# Thank You for Contacting Sandalwood Properties

Dear {{ $formData['firstName'] }},

Thank you for reaching out to Sandalwood Properties. We have received your inquiry regarding **{{ $formData['subject'] }}** and appreciate you taking the time to contact us.

## What Happens Next?
- Our team will review your message and get back to you within **24 hours**
- We'll connect you with the most appropriate team member to assist with your inquiry
- You can expect a personalized response addressing your specific needs

## Your Inquiry Details:
- **Subject:** {{ $formData['subject'] }}
- **Submitted:** {{ $formData['submitted_at'] }}
- **Reference:** #{{ substr(md5($formData['email'] . $formData['submitted_at']), 0, 8) }}

If you have any urgent questions, feel free to contact us directly at:

📞 **Phone:** +254 700 000000  
📧 **Email:** info@sandalwood.co.ke  
🏢 **Address:** Sandalwood Plaza, Westlands, Nairobi

We look forward to assisting you with your real estate needs!

<x-mail::button :url="'https://sandalwood.co.ke/projects'">
View Our Projects
</x-mail::button>

Warm regards,<br>
**The Sandalwood Properties Team**<br>
*Building a Legacy of Enduring Quality*
</x-mail::message>