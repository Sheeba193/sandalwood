<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormSubmitted;
use App\Mail\ContactFormConfirmation;
use App\Models\NewsletterSubscription;
use App\Models\ContactSubmission;
use Inertia\Inertia;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class ContactController extends Controller
{
    /**
     * Show the contact page
     */
    public function show()
    {
        return Inertia::render('Contact', [
            // Explicitly pass any initial data if needed
        ]);
    }

    /**
     * Sanitize and format phone number
     */
    private function sanitizePhoneNumber($phone, $countryCode = 'KE')
    {
        // Remove any non-numeric characters except '+'
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // If phone number doesn't start with '+', add the country code
        if (!str_starts_with($phone, '+')) {
            // Get the dial code for the country
            $dialCode = $this->getDialCode($countryCode);
            if ($dialCode) {
                // Remove any leading zeros from the phone number
                $phone = ltrim($phone, '0');
                $phone = '+' . $dialCode . $phone;
            }
        }

        return $phone;
    }

    /**
     * Get dial code for country code
     */
    private function getDialCode($countryCode)
    {
        $countryCodes = [
            'AF' => '93', 'AL' => '355', 'DZ' => '213', 'AD' => '376', 'AO' => '244',
            'AG' => '1', 'AR' => '54', 'AM' => '374', 'AU' => '61', 'AT' => '43',
            'AZ' => '994', 'BS' => '1', 'BH' => '973', 'BD' => '880', 'BB' => '1',
            'BY' => '375', 'BE' => '32', 'BZ' => '501', 'BJ' => '229', 'BT' => '975',
            'BO' => '591', 'BA' => '387', 'BW' => '267', 'BR' => '55', 'BN' => '673',
            'BG' => '359', 'BF' => '226', 'BI' => '257', 'KH' => '855', 'CM' => '237',
            'CA' => '1', 'CV' => '238', 'CF' => '236', 'TD' => '235', 'CL' => '56',
            'CN' => '86', 'CO' => '57', 'KM' => '269', 'CG' => '242', 'CD' => '243',
            'CR' => '506', 'HR' => '385', 'CU' => '53', 'CY' => '357', 'CZ' => '420',
            'DK' => '45', 'DJ' => '253', 'DM' => '1', 'DO' => '1', 'EC' => '593',
            'EG' => '20', 'SV' => '503', 'GQ' => '240', 'ER' => '291', 'EE' => '372',
            'ET' => '251', 'FJ' => '679', 'FI' => '358', 'FR' => '33', 'GA' => '241',
            'GM' => '220', 'GE' => '995', 'DE' => '49', 'GH' => '233', 'GR' => '30',
            'GD' => '1', 'GT' => '502', 'GN' => '224', 'GW' => '245', 'GY' => '592',
            'HT' => '509', 'HN' => '504', 'HU' => '36', 'IS' => '354', 'IN' => '91',
            'ID' => '62', 'IR' => '98', 'IQ' => '964', 'IE' => '353', 'IL' => '972',
            'IT' => '39', 'JM' => '1', 'JP' => '81', 'JO' => '962', 'KZ' => '7',
            'KE' => '254', 'KI' => '686', 'KW' => '965', 'KG' => '996', 'LA' => '856',
            'LV' => '371', 'LB' => '961', 'LS' => '266', 'LR' => '231', 'LY' => '218',
            'LI' => '423', 'LT' => '370', 'LU' => '352', 'MG' => '261', 'MW' => '265',
            'MY' => '60', 'MV' => '960', 'ML' => '223', 'MT' => '356', 'MH' => '692',
            'MR' => '222', 'MU' => '230', 'MX' => '52', 'FM' => '691', 'MD' => '373',
            'MC' => '377', 'MN' => '976', 'ME' => '382', 'MA' => '212', 'MZ' => '258',
            'MM' => '95', 'NA' => '264', 'NR' => '674', 'NP' => '977', 'NL' => '31',
            'NZ' => '64', 'NI' => '505', 'NE' => '227', 'NG' => '234', 'KP' => '850',
            'NO' => '47', 'OM' => '968', 'PK' => '92', 'PW' => '680', 'PA' => '507',
            'PG' => '675', 'PY' => '595', 'PE' => '51', 'PH' => '63', 'PL' => '48',
            'PT' => '351', 'QA' => '974', 'RO' => '40', 'RU' => '7', 'RW' => '250',
            'KN' => '1', 'LC' => '1', 'VC' => '1', 'WS' => '685', 'SM' => '378',
            'ST' => '239', 'SA' => '966', 'SN' => '221', 'RS' => '381', 'SC' => '248',
            'SL' => '232', 'SG' => '65', 'SK' => '421', 'SI' => '386', 'SB' => '677',
            'SO' => '252', 'ZA' => '27', 'KR' => '82', 'SS' => '211', 'ES' => '34',
            'LK' => '94', 'SD' => '249', 'SR' => '597', 'SZ' => '268', 'SE' => '46',
            'CH' => '41', 'SY' => '963', 'TW' => '886', 'TJ' => '992', 'TZ' => '255',
            'TH' => '66', 'TL' => '670', 'TG' => '228', 'TO' => '676', 'TT' => '1',
            'TN' => '216', 'TR' => '90', 'TM' => '993', 'TV' => '688', 'UG' => '256',
            'UA' => '380', 'AE' => '971', 'GB' => '44', 'US' => '1', 'UY' => '598',
            'UZ' => '998', 'VU' => '678', 'VA' => '379', 'VE' => '58', 'VN' => '84',
            'YE' => '967', 'ZM' => '260', 'ZW' => '263'
        ];

        return $countryCodes[strtoupper($countryCode)] ?? null;
    }

    /**
     * Validate phone number using libphonenumber
     */
    private function validatePhoneNumber($phone, $countryCode = 'KE')
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parsedNumber = $phoneUtil->parse($phone, $countryCode);
            return $phoneUtil->isValidNumber($parsedNumber);
        } catch (NumberParseException $e) {
            return false;
        }
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        // Get country code from request or default to KE
        $countryCode = $request->countryCode ?? 'KE';

        // Sanitize phone number
        $sanitizedPhone = $this->sanitizePhoneNumber($request->phone, $countryCode);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:5000',
            'keepUpdated' => 'boolean',
            'countryCode' => 'string|size:2',
            'dialCode' => 'string',
        ], [
            'fullName.required' => 'Full name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'phone.required' => 'Phone number is required',
        ]);

        if (class_exists('libphonenumber\PhoneNumberUtil')) {
            if (!$this->validatePhoneNumber($sanitizedPhone, $countryCode)) {
                $validator->errors()->add('phone', 'Please enter a valid phone number for the selected country');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $formData = [
                'full_name' => $request->fullName,
                'email' => $request->email,
                'phone' => $sanitizedPhone,
                'subject' => $request->input('subject', 'General enquiry'),
                'message' => $request->input('message', 'A contact request was submitted via the contact form.'),
                'country_code' => $countryCode,
                'dial_code' => $request->dialCode ?? $this->getDialCode($countryCode),
                'keep_updated' => $request->keepUpdated ?? false,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            // Save to database
            $contact = ContactSubmission::create($formData);

            // Log the submission
            Log::info('Contact form submission saved', [
                'id' => $contact->id,
                'email' => $contact->email,
                'full_name' => $contact->full_name,
                'phone' => $contact->phone,
                'country_code' => $contact->country_code
            ]);

            Mail::to(config('mail.contact_to'))->send(new ContactFormSubmitted([
                'fullName' => $contact->full_name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'submitted_at' => $contact->created_at->toDateTimeString(),
                'ip_address' => $contact->ip_address,
            ]));

            // Send confirmation email to user (commented out for testing)
            // Mail::to($request->email)->send(new ContactFormConfirmation($contact));

            // If user wants to be updated, add to newsletter
            if ($request->keepUpdated) {
                try {
                    NewsletterSubscription::firstOrCreate(
                        ['email' => $request->email],
                        [
                            'name' => $request->fullName,
                            'phone' => $sanitizedPhone,
                            'country_code' => $countryCode,
                            'ip_address' => $request->ip(),
                            'subscribed_at' => now(),
                        ]
                    );
                    Log::info('User added to newsletter from contact form', [
                        'email' => $request->email,
                        'phone' => $sanitizedPhone
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to add user to newsletter from contact form', [
                        'email' => $request->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Clear any previous flash messages and set success
            session()->forget(['success', 'error']);

            return redirect()->back()->with([
                'success' => 'Thank you for your message! We have received your inquiry and will respond within 24 hours.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());

            // Clear any previous flash messages and set error
            session()->forget(['success', 'error']);

            return redirect()->back()
                ->with('error', 'Sorry, there was an error submitting your message. Please try again or contact us directly at info@sandalwoodproperties.co.ke')
                ->withInput();
        }
    }

    /**
     * Handle newsletter subscription
     */
    public function subscribe(Request $request)
    {
        // Validate the newsletter form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:newsletter_subscriptions,email',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Please enter your name',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already subscribed to our newsletter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('newsletter_errors', true);
        }

        try {
            // Sanitize phone if provided
            $sanitizedPhone = null;
            if ($request->phone) {
                $countryCode = $request->countryCode ?? 'KE';
                $sanitizedPhone = $this->sanitizePhoneNumber($request->phone, $countryCode);
            }

            // Save to database
            NewsletterSubscription::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $sanitizedPhone,
                'country_code' => $request->countryCode ?? 'KE',
                'ip_address' => $request->ip(),
                'subscribed_at' => now(),
            ]);

            Log::info('Newsletter subscription created: ' . $request->email);

            // Clear any previous newsletter flash messages
            session()->forget(['newsletter_success', 'newsletter_error']);

            return redirect()->back()->with([
                'newsletter_success' => 'Thank you for subscribing! You have been added to our newsletter and will receive updates on new projects and investment opportunities.'
            ]);

        } catch (\Exception $e) {
            Log::error('Newsletter subscription failed: ' . $e->getMessage());

            // Clear any previous newsletter flash messages
            session()->forget(['newsletter_success', 'newsletter_error']);

            return redirect()->back()
                ->with('newsletter_error', 'Sorry, there was an error with your subscription. Please try again.')
                ->withInput()
                ->with('newsletter_errors', true);
        }
    }
}
