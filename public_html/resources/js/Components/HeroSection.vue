<template>
    <section class="hero-section">
        <!-- Sticky Header -->
        <header class="first-header">
            <div class="logo">SANDALWOOD</div>
            <div class="nav-links">
                <Link href="/">Home</Link>
                <Link href="/properties">Properties</Link>
                <Link href="/about">About</Link>
                <Link href="/services">Services</Link>
                <Link href="/contact">Contact</Link>
            </div>
            <button class="mobile-menu-btn" @click="toggleMobileMenu">
                <i class="fas fa-bars"></i>
            </button>
        </header>

        <!-- Hero Content -->
        <div class="hero-content">
            <div class="hero-subtitle">Crafting Timeless</div>
            <h1 class="hero-title">Excellence</h1>
            <p class="hero-description">
                Kenya's premier real estate developer, creating architectural masterpieces for over two decades
            </p>
            <Link href="/properties" class="cta-button">Explore Properties</Link>
        </div>
        
        <div class="scroll-indicator">
            <span>Scroll Down</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
    const navLinks = document.querySelector('.nav-links');
    if (navLinks) {
        navLinks.style.display = isMobileMenuOpen.value ? 'flex' : 'none';
    }
};

onMounted(() => {
    // Hero content animation
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.style.opacity = '0';
        heroContent.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            heroContent.style.transition = 'opacity 1s ease, transform 1s ease';
            heroContent.style.opacity = '1';
            heroContent.style.transform = 'translateY(0)';
        }, 300);
    }

    // Handle window resize for mobile menu
    window.addEventListener('resize', () => {
        const navLinks = document.querySelector('.nav-links');
        if (window.innerWidth > 576) {
            navLinks.style.display = 'flex';
            isMobileMenuOpen.value = false;
        } else {
            navLinks.style.display = 'none';
            isMobileMenuOpen.value = false;
        }
    });
});
</script>

<style scoped>
/* First Header - Sticky */
.first-header {
    position: sticky;
    top: 0;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 15px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 28px;
    font-weight: 700;
    color: #8B4513;
    letter-spacing: 1px;
}

.nav-links {
    display: flex;
    gap: 30px;
}

.nav-links a {
    color: #333;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: color 0.3s;
    position: relative;
}

.nav-links a:hover {
    color: #8B4513;
}

.nav-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -5px;
    left: 0;
    background-color: #8B4513;
    transition: width 0.3s;
}

.nav-links a:hover::after {
    width: 100%;
}

/* Hero Section */
.hero-section {
    position: relative;
    height: 100vh;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('https://images.unsplash.com/photo-1600585154340-6f676d9fda65?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    padding: 0 20px;
}

.hero-content {
    max-width: 900px;
}

.hero-subtitle {
    font-size: 24px;
    font-weight: 500;
    letter-spacing: 3px;
    margin-bottom: 20px;
    text-transform: uppercase;
    color: #d4af37;
}

.hero-title {
    font-size: 68px;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero-description {
    font-size: 20px;
    line-height: 1.6;
    margin-bottom: 40px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    font-weight: 300;
}

.cta-button {
    display: inline-block;
    background-color: #d4af37;
    color: #000;
    padding: 16px 40px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-top: 20px;
}

.cta-button:hover {
    background-color: #e8c352;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.scroll-indicator i {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Mobile Responsive Styles */
@media (max-width: 768px) {
    .first-header {
        padding: 15px 20px;
    }
    
    .nav-links {
        gap: 15px;
    }
    
    .hero-title {
        font-size: 42px;
    }
    
    .hero-description {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        flex-direction: column;
        padding: 20px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .hero-title {
        font-size: 36px;
    }
    
    .hero-subtitle {
        font-size: 18px;
    }
    
    .mobile-menu-btn {
        display: block;
        background: none;
        border: none;
        font-size: 24px;
        color: #333;
        cursor: pointer;
    }
}
</style>