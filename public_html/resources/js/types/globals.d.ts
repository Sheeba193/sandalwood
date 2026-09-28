import { AppPageProps } from '@/types/index';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

declare module 'vue' {
    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
}

// Add the missing Vue module declaration for *.vue files
declare module '*.vue' {
    import type { DefineComponent } from 'vue'
    const component: DefineComponent<{}, {}, any>
    export default component
}

// Global type declarations
declare global {
    interface Window {
        // Add any custom window properties if needed
    }
    
    // Custom events
    interface CustomEventMap {
        'theme-changed': CustomEvent<{ darkMode: boolean }>
    }
    
    interface WindowEventMap extends CustomEventMap {
        // Extend the window event map
    }
}

export {}