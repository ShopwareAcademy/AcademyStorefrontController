import { defineConfig, devices } from '@playwright/test';
import dotenv from 'dotenv';

dotenv.config();

process.env['SHOPWARE_ADMIN_USERNAME'] = process.env['SHOPWARE_ADMIN_USERNAME'] || 'admin';
process.env['SHOPWARE_ADMIN_PASSWORD'] = process.env['SHOPWARE_ADMIN_PASSWORD'] || 'shopware';
process.env['MAILPIT_BASE_URL'] = process.env['MAILPIT_BASE_URL'] || 'http://localhost:8025';
process.env['APP_URL'] = process.env['APP_URL'] ?? 'http://localhost:8000';
process.env['APP_URL'] = process.env['APP_URL'].replace(/\/+$/, '') + '/';

if (process.env['ADMIN_URL']) {
  process.env['ADMIN_URL'] = process.env['ADMIN_URL'].replace(/\/+$/, '') + '/';
} else {
  process.env['ADMIN_URL'] = process.env['APP_URL'] + 'admin/';
}

/**
 * See https://playwright.dev/docs/test-configuration
 */
export default defineConfig({
  testDir: './tests',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  workers: process.env.CI ? 1 : undefined,
  reporter: 'html',
  use: {
    screenshot: 'only-on-failure',
    baseURL: process.env.APP_URL,
    trace: 'on-first-retry',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },

    {
      name: 'firefox',
      use: { ...devices['Desktop Firefox'] },
    },
  ],
});
