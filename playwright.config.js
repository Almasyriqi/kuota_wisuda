import { defineConfig, devices } from '@playwright/test';

/**
 * Config ini juga dipakai untuk men-generate screenshot manual pengguna
 * di docs/USER_MANUAL.md (lihat tests/e2e/screenshots.spec.js).
 * Browser Chromium diarahkan ke instalasi lokal bila tersedia (mis. di
 * sandbox CI) supaya tidak perlu download ulang lewat `playwright install`.
 */
const localChromium = process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE;

export default defineConfig({
    testDir: './tests/e2e',
    fullyParallel: false,
    workers: 1,
    retries: 0,
    reporter: 'list',
    use: {
        baseURL: 'http://127.0.0.1:8000',
        viewport: { width: 1280, height: 800 },
        launchOptions: localChromium ? { executablePath: localChromium } : {},
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
    ],
    webServer: {
        command: 'php artisan serve --port=8000',
        url: 'http://127.0.0.1:8000',
        reuseExistingServer: true,
        timeout: 30 * 1000,
    },
});
