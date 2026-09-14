import './bootstrap';
import './animated-tabs';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { MainNavigationTabs } from './components/ui/main-navigation-tabs';
import { DefaultDemo, CustomColorDemo } from './components/ui/demo';

// Mount komponen React MainNavigationTabs jika container mount tersedia di DOM
document.addEventListener('DOMContentLoaded', () => {
    const navMount = document.getElementById('react-main-nav');
    if (navMount) {
        const root = createRoot(navMount);
        root.render(React.createElement(MainNavigationTabs));
    }

    const demoMount = document.getElementById('react-expandable-tabs-demo');
    if (demoMount) {
        const root = createRoot(demoMount);
        root.render(React.createElement(DefaultDemo));
    }
});

export { MainNavigationTabs, DefaultDemo, CustomColorDemo };
