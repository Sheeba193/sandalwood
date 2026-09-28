<template>
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <button
            v-if="!isOpen"
            @click="openChat"
            class="bg-primary hover:bg-amber-700 text-white p-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 flex items-center justify-center group relative"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>

            <!-- Online Status Indicator -->
            <div class="absolute -top-1 -right-1">
                <div class="relative">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-ping absolute"></div>
                    <div class="w-3 h-3 bg-green-500 rounded-full relative"></div>
                </div>
            </div>
        </button>

        <!-- Chat Window -->
        <div v-if="isOpen" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-80 h-96 flex flex-col border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-100">
            <!-- Header -->
            <div class="bg-amber-600 text-white p-4 rounded-t-2xl flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <!-- Online Status with Pulse -->
                    <div class="relative">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-ping absolute"></div>
                        <div class="w-3 h-3 bg-green-400 rounded-full relative"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold">Sandi - AI Assistant</h3>
                        <p class="text-amber-100 text-xs flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                            Online • Sandalwood Properties
                        </p>
                    </div>
                </div>
                <button @click="closeChat" class="text-white hover:text-amber-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Messages Container -->
            <div ref="messagesContainer" class="flex-1 p-4 overflow-y-auto space-y-4">
                <!-- Opening Message -->
                <div v-if="showOpening" class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-bl-none px-4 py-3 max-w-[80%]">
                        <p class="text-gray-800 dark:text-gray-200 text-sm">
                            Hello! I'm Sandi, your Sandalwood Properties AI assistant! 🏡

I'm here to help you explore our 15 premium real estate opportunities in Kenya. To provide you with the best service, could you please share your email address?
                        </p>
                    </div>
                </div>

                <!-- Messages -->
                <div v-for="(message, index) in messages" :key="index" :class="['flex', message.type === 'user' ? 'justify-end' : 'justify-start']">
                    <div :class="[
                        'rounded-2xl px-4 py-3 max-w-[80%]',
                        message.type === 'user'
                            ? 'bg-amber-500 text-white rounded-br-none'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-bl-none'
                    ]">
                        <p class="text-sm whitespace-pre-line">{{ message.text }}</p>
                        <p class="text-xs opacity-70 mt-1">{{ message.timestamp }}</p>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div v-if="isLoading" class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-bl-none px-4 py-3">
                        <div class="flex items-center space-x-2">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                            <span class="text-xs text-gray-500">Sandi is typing...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <form @submit.prevent="sendMessage" class="flex space-x-2">
                    <input
                        v-model="userInput"
                        :placeholder="emailProvided ? 'Ask about properties, investments, or schedule a viewing...' : 'Enter your email address...'"
                        :disabled="isLoading"
                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm"
                        type="text"
                    />
                    <button
                        type="submit"
                        :disabled="!userInput.trim() || isLoading"
                        class="bg-amber-600 hover:bg-amber-700 disabled:bg-gray-400 text-white p-2 rounded-lg transition-colors duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">
                    Powered by NexoraTech • Your data is secure
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, nextTick, onMounted } from 'vue'

// State (Using JavaScript instead of TypeScript to avoid errors)
const isOpen = ref(false)
const showOpening = ref(false)
const userInput = ref('')
const messages = ref([])
const isLoading = ref(false)
const emailProvided = ref(false)
const userEmail = ref('')
const messagesContainer = ref()

// Open chat function
const openChat = () => {
    isOpen.value = true
    showOpening.value = true
}

// Close chat function
const closeChat = () => {
    isOpen.value = false
    showOpening.value = false
}

// Scroll to bottom of messages
const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
        }
    })
}

// Validate email
const isValidEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
}

// Get current time for timestamps
const getCurrentTime = () => {
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
}

// Send message function
const sendMessage = async () => {
    if (!userInput.value.trim()) return

    const inputText = userInput.value.trim()
    userInput.value = ''

    // Handle email collection
    if (!emailProvided.value) {
        if (!isValidEmail(inputText)) {
            messages.value.push({
                text: "Please enter a valid email address to continue.",
                type: 'assistant',
                timestamp: getCurrentTime()
            })
            scrollToBottom()
            return
        }

        userEmail.value = inputText
        emailProvided.value = true

        messages.value.push({
            text: inputText,
            type: 'user',
            timestamp: getCurrentTime()
        })

        // Welcome message after email collection
        isLoading.value = true
        setTimeout(() => {
            messages.value.push({
                text: `Thank you ${inputText.split('@')[0]}! ✨\n\nI'm Sandi, your Sandalwood Properties assistant. I'm here to help you explore our 15 premium developments including:\n\n🏡 Sandalwood Loresho (Under Construction)\n🏢 The Convex (Completed)\n🌊 Sandalwood Waterfront (Planning)\n🏞️ Sandalwood Clyde Gardens\n🏙️ Sandalwood Lenana Road\n...and 10 more premium projects!\n\nWhat would you like to know about our properties today?`,
                type: 'assistant',
                timestamp: getCurrentTime()
            })
            isLoading.value = false
            scrollToBottom()
        }, 1000)

        scrollToBottom()
        return
    }

    // Add user message to chat
    messages.value.push({
        text: inputText,
        type: 'user',
        timestamp: getCurrentTime()
    })

    scrollToBottom()

    // Process AI response
    isLoading.value = true
    try {
        const response = await getAIResponse(inputText, userEmail.value)

        messages.value.push({
            text: response,
            type: 'assistant',
            timestamp: getCurrentTime()
        })
    } catch (error) {
        messages.value.push({
            text: "I apologize, but I'm having trouble connecting right now. Please try again in a moment or contact us directly at info@sandalwood.co.ke",
            type: 'assistant',
            timestamp: getCurrentTime()
        })
    } finally {
        isLoading.value = false
        scrollToBottom()
    }
}

// AI Response Function with DeepSeek API integration
const getAIResponse = async (userMessage, email) => {
    try {
        const response = await fetch('/api/ai-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                message: userMessage,
                email: email,
                context: messages.value.slice(-5).map(msg => ({
                    text: msg.text,
                    type: msg.type
                }))
            })
        })

        if (response.ok) {
            const data = await response.json()
            return data.response
        } else {
            throw new Error('API request failed')
        }
    } catch (error) {
        console.error('DeepSeek API error:', error)
        // Use fallback responses
        return getFallbackResponse(userMessage)
    }
}

// Fallback responses for when API fails
const getFallbackResponse = (userMessage) => {
    const message = userMessage.toLowerCase()

    // Property-specific responses
    if (message.includes('loresho')) {
        return "🏡 **Sandalwood Loresho** - Prestigious Living Redefined!\n\nLocated in the exclusive Loresho neighborhood, this development offers 2-4 bedroom luxury apartments with premium finishes. \n\n• **Status:** Under Construction\n• **Completion:** 2024\n• **Price Range:** KSH 46M - 85M\n• **Features:** Swimming pool, gym, 24/7 security, underground parking\n\nPerfect for families and investors seeking premium urban living!"
    }

    if (message.includes('convex')) {
        return "🏢 **The Convex** - Architectural Masterpiece!\n\nLocated in Westlands, this completed development features unique convex design and luxury finishes.\n\n• **Status:** Completed\n• **Price Range:** KSH 85M - 160M\n• **Features:** Rooftop pool, smart home, panoramic views\n• **Units Available:** 12\n\nReady for immediate occupancy!"
    }

    if (message.includes('waterfront') || message.includes('lake')) {
        return "🌊 **Sandalwood Waterfront** - Luxury Lakeside Living!\n\nPremium waterfront apartments offering stunning lake views in Lakeview, Nairobi.\n\n• **Status:** Planning\n• **Price Range:** KSH 120M - 250M\n• **Features:** Private docks, infinity pool, marina access\n• **Completion:** 2026\n\nPerfect for luxury waterfront lifestyle enthusiasts!"
    }

    if (message.includes('clyde') || message.includes('gardens')) {
        return "🏞️ **Sandalwood Clyde Gardens** - Exclusive Gated Community!\n\nModern townhouses with private gardens in Clyde Gardens, Nairobi.\n\n• **Status:** Planning\n• **Price Range:** KSH 35M - 65M\n• **Features:** Gated community, clubhouse, children's play area\n• **Completion:** 2025\n\nIdeal for families seeking security and community living!"
    }

    if (message.includes('lenana')) {
        return "🏙️ **Sandalwood Lenana Road** - Urban Commercial Hub!\n\nModern commercial and residential complex in the heart of Nairobi.\n\n• **Status:** Under Construction\n• **Price Range:** KSH 28M - 75M\n• **Features:** Commercial spaces, rooftop garden, business center\n• **Completion:** 2024\n\nGreat for investors and business owners!"
    }

    if (message.includes('properties') || message.includes('projects') || message.includes('list')) {
        return "🏡 **Our Premium Portfolio - 15 Developments!**\n\nWe have projects across prime locations:\n\n**Under Construction:**\n• Sandalwood Loresho\n• Sandalwood Lenana Road  \n• Sandalwood Riverside\n• Silver Terraces\n• The Colosseum\n\n**Completed:**\n• The Convex\n• Sandalwood Kitisuru\n• Chilly Breezes\n• The Haven\n\n**Planning Phase:**\n• Sandalwood Clyde Gardens\n• Sandalwood Waterfront\n• Sandalwood Brookside\n• Sandalwood Othaya\n• Ivory Terraces\n• Oak & Ivy\n\nWhich project interests you most? 😊"
    }

    if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
        return `Hello! 👋 I'm Sandi, your Sandalwood Properties assistant!

I'm thrilled to help you explore our 15 premium real estate opportunities in Kenya.

We have exciting projects across Nairobi, Limuru, Othaya, and Mombasa with prices ranging from KSH 25M to 350M.

What type of property are you interested in? 🏡`
    }

    if (message.includes('price') || message.includes('cost') || message.includes('how much')) {
        return "💰 **Investment Opportunities Across All Budgets!**\n\nOur properties range from:\n• **Entry Level:** KSH 25M - 50M (Sandalwood Othaya)\n• **Mid Range:** KSH 35M - 95M (Multiple projects)\n• **Premium:** KSH 85M - 180M (The Convex, The Colosseum)\n• **Luxury:** KSH 120M - 350M (Waterfront, The Haven)\n\nFor accurate, up-to-date pricing and special offers, I'd recommend speaking with our sales team who can provide personalized quotes. Would you like me to connect you? 📞"
    }

    if (message.includes('investment') || message.includes('return') || message.includes('roi')) {
        return "📈 **Excellent Investment Potential!**\n\nOur properties offer:\n• **Capital Appreciation:** 15-25% annually in prime locations\n• **Rental Yields:** 6-10% in high-demand areas\n• **Developer Financing:** Flexible payment plans available\n• **Guaranteed Returns:** Some projects offer buy-back options\n\nWhich project are you considering for investment? I can provide detailed ROI analysis! 💼"
    }

    if (message.includes('viewing') || message.includes('visit') || message.includes('tour')) {
        return "📅 **Schedule a Site Viewing!**\n\nI'd be happy to arrange a personalized site viewing for you! Our sales team can show you:\n• Completed projects for immediate viewing\n• Under-construction sites with progress updates\n• Show apartments and model units\n• Neighborhood tours\n\nPlease provide your preferred dates and times, and I'll coordinate with our team! 🗓️"
    }

    if (message.includes('contact') || message.includes('phone') || message.includes('email')) {
        return "📞 **Connect With Our Team!**\n\n**Sales Office:** +254 700 000000\n**Email:** info@sandalwood.co.ke\n**Office:** Sandalwood Plaza, Westlands, Nairobi\n**Hours:** Mon-Fri 8AM-6PM, Sat 9AM-4PM\n\nOur expert team can provide:\n• Detailed project information\n• Investment analysis\n• Financing options\n• Site viewing arrangements\n\nWould you like me to have someone contact you directly? 👍"
    }

    if (message.includes('thanks') || message.includes('thank')) {
        return "You're very welcome! 😊\n\nIs there anything else about our 15 premium developments I can help you with? Whether it's property details, investment analysis, or scheduling viewings, I'm here to assist!\n\nRemember, we have projects to suit every budget and lifestyle preference! 🏡"
    }

    if (message.includes('bye') || message.includes('goodbye')) {
        return "Thank you for chatting with Sandi! 👋\n\nIt was a pleasure helping you explore Sandalwood Properties. Remember, we have 15 premium developments waiting for you!\n\nFeel free to reach out anytime for:\n• Property information\n• Investment advice\n• Site viewing arrangements\n• Market insights\n\nHave a wonderful day! 🌟"
    }

    return "Thank you for your interest in Sandalwood Properties! 🏡\n\nAs Kenya's premier real estate developer since 2003, we create enduring value through 15 quality developments in prime locations.\n\nI can help you with:\n• Detailed project information across all 15 developments\n• Investment analysis and ROI projections\n• Pricing and payment plan options\n• Site viewing scheduling\n• Market insights and location advantages\n\nWhat specific information would you like about our properties? 😊"
}

// Auto-scroll when new messages are added
onMounted(() => {
    scrollToBottom()
})
</script>

<style scoped>
.messages-container::-webkit-scrollbar {
    width: 4px;
}

.messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

@media (prefers-color-scheme: dark) {
    .messages-container::-webkit-scrollbar-track {
        background: #374151;
    }

    .messages-container::-webkit-scrollbar-thumb {
        background: #6b7280;
    }

    .messages-container::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
}
</style>
