import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h, type DefineComponent } from 'vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const appName = import.meta.env.VITE_APP_NAME || 'Sandalwood Properties';

// Initialize theme with light as default

const initializeTheme = () => {
    const savedTheme = localStorage.getItem('theme');

    // Default to light if no saved preference
    if (!savedTheme) {
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
    } else if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

// Run theme initialization
initializeTheme();

// Optional: Listen for system theme changes if you want
if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        // Only update if user hasn't explicitly set a preference
        if (!localStorage.getItem('theme')) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    });
}

createInertiaApp({
    title: (title: string) => title ? `${title} - ${appName}` : appName,
    resolve: (name: string) => {
        // Get all page components as import functions
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue');

        // Construct the path
        const pagePath = `./pages/${name}.vue`;

        // Get the import function for this page
        const importFunction = pages[pagePath];

        if (!importFunction) {
            console.error(`Page not found: ${pagePath}`);
            throw new Error(`Page not found: ${name}`);
        }

        // Call the import function to load the component
        return importFunction().then((module) => {
            // Return the module with proper structure for Inertia
            return module;
        });
    },
    setup({ el, App, props, plugin }: {
        el: Element;
        App: DefineComponent;
        props: Record<string, unknown>;
        plugin: unknown;
    }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ToastPlugin)
            .provide('appName',  import.meta.env.VITE_APP_NAME || 'Sandalwood Properties')
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
