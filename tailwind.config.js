import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
            bg: 'var(--bg)', surface: 'var(--surface)', surface2: 'var(--surface-2)',
            fg: 'var(--fg)', muted: 'var(--muted)', line: 'var(--line)',
            accent: 'var(--accent)', accentsoft: 'var(--accent-soft)', link: 'var(--link)',
            chili: 'var(--chili)', scarlet: 'var(--scarlet)', cinnabar: 'var(--cinnabar)',
            rose: 'var(--rose)', fire: 'var(--fire)', vermilion: 'var(--vermilion)'
            },
            fontFamily: {
            display: ['"Bricolage Grotesque"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            sans: ['"Instrument Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'ui-monospace', 'Menlo', 'monospace']
            }
        },
    },

    plugins: [forms],
};
