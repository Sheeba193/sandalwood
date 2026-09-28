<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'email' => 'required|email',
            'context' => 'sometimes|array'
        ]);

        // Get API key from environment
        $apiKey = env('DEEPSEEK_API_KEY');

        if (!$apiKey) {
            Log::error('DeepSeek API key not found in environment');
            return response()->json([
                'response' => $this->getFallbackResponse($request->message)
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.deepseek.com/v1/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => $this->buildMessages($request->message, $request->email, $request->context),
                'max_tokens' => 1000,
                'temperature' => 0.7,
                'stream' => false
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return response()->json([
                    'response' => $responseData['choices'][0]['message']['content']
                ]);
            }

            Log::error('DeepSeek API Error: ' . $response->body());
            
            return response()->json([
                'response' => $this->getFallbackResponse($request->message)
            ], 500);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            
            return response()->json([
                'response' => $this->getFallbackResponse($request->message)
            ], 500);
        }
    }

    private function buildMessages(string $userMessage, string $email, ?array $context = [])
    {
        $sandalwoodContext = "
You are Sandi, the AI real estate assistant for Sandalwood Properties - Kenya's premier real estate developer since 2003.

# COMPANY PROFILE
- Name: Sandalwood Properties
- Founded: 2003
- Mission: Building dreams, shaping communities, creating lasting value
- Location: Sandalwood Plaza, Westlands, Nairobi
- Contact: info@sandalwood.co.ke | +254 700 000000
- Current Projects: Sandalwood Residences (Westlands), Sandalwood Loresho, Sandalwood Beach Villas (Diani)

# YOUR ROLE & BEHAVIOR:
1. Be enthusiastic, professional, and incredibly helpful - like a top real estate consultant
2. Focus on the premium quality and strategic value of Sandalwood properties
3. Highlight investment opportunities and ROI potential in Kenyan real estate
4. Offer to schedule site viewings with our sales team
5. NEVER mention exact prices - always say 'contact our sales team for competitive pricing'
6. Emphasize our 20+ years of experience and proven track record
7. Use emojis tastefully to make responses engaging but professional
8. Be specific about locations, features, completion timelines, and benefits
9. Always maintain a positive, customer-focused tone
10. Make potential buyers feel excited about investing with Sandalwood

# PROJECT DETAILS:

## 🏢 Sandalwood Residences (Westlands)
- Luxury apartments in prime Westlands location
- 2-4 bedroom configurations with premium finishes
- Rooftop infinity pool, modern gym, smart home features
- Underground parking and commercial spaces
- Excellent investment potential in Nairobi's premium area
- Completion: 2024

## 🏡 Sandalwood Loresho 
- Premium residential development in exclusive Loresho neighborhood
- 3-4 bedroom luxury apartments in gated community
- 24/7 security, landscaped gardens, recreational facilities
- Proximity to international schools and shopping centers
- High appreciation potential in this prime location

## 🏖️ Sandalwood Beach Villas (Diani)
- Luxury beachfront villas on Diani Beach
- 4-5 bedroom villas with ocean views and private beach access
- Infinity pools, modern Swahili architecture
- Perfect for holiday homes and luxury rental investments
- High tourism returns in coastal property market

# PRICING POLICY:
- NEVER disclose exact prices or price ranges
- ALWAYS redirect pricing questions to sales team
- Use phrases: 'competitive pricing', 'value-based pricing', 'contact for quotes'
- Emphasize that all pricing is negotiable based on unit selection

Current user email: {$email}
";

        $messages = [
            ['role' => 'system', 'content' => $sandalwoodContext],
        ];

        // Add conversation context (last few messages)
        if (!empty($context)) {
            foreach ($context as $msg) {
                $messages[] = [
                    'role' => $msg['type'] === 'user' ? 'user' : 'assistant',
                    'content' => $msg['text']
                ];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        return $messages;
    }

    private function getFallbackResponse(string $userMessage): string
    {
        $message = strtolower($userMessage);
        
        if (str_contains($message, 'loresho')) {
            return "🏡 **Sandalwood Loresho** - Prestigious Living Redefined!\n\nLocated in the exclusive Loresho neighborhood, this development offers 3-4 bedroom luxury apartments with premium finishes in a secure gated community.\n\n• **Features:** 24/7 security, landscaped gardens, recreational facilities\n• **Location:** Prime Loresho area near international schools\n• **Completion:** 2024\n• **Investment Potential:** Excellent appreciation in this exclusive neighborhood\n\nFor competitive pricing and special offers, please contact our sales team. Would you like to schedule a site viewing? 📋";
        }
        
        if (str_contains($message, 'residences') || str_contains($message, 'westlands')) {
            return "🏢 **Sandalwood Residences** - Urban Luxury in Westlands!\n\nSophisticated apartments in Nairobi's premier business district:\n• 2-4 bedroom configurations with premium finishes\n• Rooftop infinity pool & modern gym facility\n• Smart home technology integration\n• Prime Westlands location with excellent connectivity\n• Underground parking and commercial spaces\n\n📅 **Flexible Payment Plans** available\n🎯 **Strong Investment Potential** in this prime area\n\nFor current pricing, please contact our sales team for personalized quotes. Interested in specific unit types?";
        }
        
        if (str_contains($message, 'beach') || str_contains($message, 'diani') || str_contains($message, 'coastal')) {
            return "🏖️ **Sandalwood Beach Villas** - Coastal Paradise Awaits!\n\nExperience luxury beachfront living on Kenya's stunning coastline:\n• 4-5 bedroom luxury villas with ocean views\n• Private beach access and infinity pools\n• Modern Swahili architectural design\n• Perfect for holiday homes and luxury rentals\n• High tourism rental potential\n\n📍 **Exclusive Diani Beach location**\n📈 **Excellent Rental Returns** during peak seasons\n\nFor premium beachfront pricing, our sales team can provide detailed quotes based on your preferences! 🌊";
        }
        
        if (str_contains($message, 'investment') || str_contains($message, 'roi') || str_contains($message, 'return')) {
            return "📈 **Excellent Investment Opportunities with Sandalwood!**\n\nWhy invest with us?\n\n• **Proven Track Record:** 20+ years in Kenyan real estate\n• **Prime Locations:** Westlands, Loresho, Diani Beach\n• **Quality Construction:** Enduring quality since 2003\n• **Strong Market Position:** Premium developer reputation\n• **Flexible Payment Plans:** Various options available\n\n💡 **Investment Highlights:**\n- Nairobi property appreciation potential\n- Coastal tourism rental opportunities\n- Pre-construction advantage benefits\n- Professional property management available\n\nOur sales team can provide detailed investment analysis based on your goals!";
        }
        
        if (str_contains($message, 'price') || str_contains($message, 'cost') || str_contains($message, 'how much')) {
            return "Thank you for your interest in our pricing! 💰\n\nWe offer competitive, value-based pricing across all our premium developments. Since pricing varies based on:\n• Specific unit selection and size\n• Preferred payment plan terms\n• Current market conditions\n• Available promotions and offers\n\nI'd highly recommend speaking directly with our sales team for accurate, personalized pricing. They can provide detailed quotes and discuss negotiable terms based on your specific requirements.\n\nWould you like me to connect you with our sales team for comprehensive pricing information? 📞";
        }
        
        if (str_contains($message, 'viewing') || str_contains($message, 'visit') || str_contains($message, 'tour')) {
            return "📅 **Let's Schedule Your Exclusive Viewing!** 🎉\n\nI'd be delighted to arrange a personalized site tour for you! Here are our viewing options:\n\n• **Sandalwood Residences (Westlands):** Weekdays 9AM-5PM\n• **Sandalwood Loresho:** Saturdays 10AM-4PM  \n• **Sandalwood Beach Villas:** Special arrangements available\n• **Virtual Tours:** Comprehensive online viewings\n\nOur dedicated sales team will contact you to confirm your preferred time and discuss the properties in detail. Which project would you like to experience first?";
        }

        if (str_contains($message, 'hello') || str_contains($message, 'hi') || str_contains($message, 'hey')) {
            return "Hello! 👋 I'm Sandi, your dedicated Sandalwood Properties AI assistant!\n\nI'm absolutely thrilled to help you explore our premium real estate opportunities across Kenya. With over 20 years of excellence, we're committed to building dreams and creating lasting value.\n\nI can assist you with:\n🏢 Sandalwood Residences (Westlands)\n🏡 Sandalwood Loresho \n🏖️ Sandalwood Beach Villas (Diani)\n\nWhat would you like to discover first about our premium developments? 😊";
        }

        return "Thank you for your interest in Sandalwood Properties! 🏡\n\nAs Kenya's premier real estate developer since 2003, we specialize in creating enduring value through exceptional developments in prime locations.\n\nI'm here to help you with:\n• 🏢 Detailed project specifications and features\n• 📈 Investment opportunity analysis\n• 📅 Personalized site viewing arrangements\n• 💰 Competitive pricing information (via our sales team)\n• 🏗️ Construction progress and timeline updates\n\nWhich Sandalwood project would you like to explore today? Our current developments include premium options in Westlands, Loresho, and Diani Beach!";
    }
}