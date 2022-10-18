require("./bootstrap");

import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { InertiaProgress } from '@inertiajs/progress';

import ThemeProvider from '@/theme';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./pages/${name}`),
    setup({ el, App, props }) {
        return render(
          <ThemeProvider>
            <App {...props} />
          </ThemeProvider>
        , el);
    },
});

InertiaProgress.init({ color: '#EB6608' });
