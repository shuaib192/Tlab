/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary:  'rgb(var(--c-primary) / <alpha-value>)',
                accent:   'rgb(var(--c-accent) / <alpha-value>)',
                violet:   'rgb(var(--c-violet) / <alpha-value>)',
                amber:    'rgb(var(--c-amber) / <alpha-value>)',
                coral:    'rgb(var(--c-coral) / <alpha-value>)',
                ink:      'rgb(var(--c-ink) / <alpha-value>)',
                muted:    'rgb(var(--c-muted) / <alpha-value>)',
                surface:  'rgb(var(--c-surface) / <alpha-value>)',
                mint:     'rgb(var(--c-mint) / <alpha-value>)',
                gold:     'rgb(var(--c-gold) / <alpha-value>)',
                sky:      'rgb(var(--c-sky) / <alpha-value>)',
                cream:    'rgb(var(--c-cream) / <alpha-value>)',
                space:    'rgb(var(--c-space) / <alpha-value>)',
                panel:    'rgb(var(--c-panel) / <alpha-value>)',
                bubble:   'rgb(var(--c-bubble) / <alpha-value>)',
                grape:    'rgb(var(--c-grape) / <alpha-value>)',
                terra:    'rgb(var(--c-terra) / <alpha-value>)',
            },
            fontFamily: {
                sans:    ['var(--font-sans)', 'sans-serif'],
                display: ['var(--font-display)', 'sans-serif'],
                mono:    ['var(--font-mono)', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'monospace'],
            },
            zIndex: {
                60: '60',
            },
        },
    },
    plugins: [],
};