// @ts-check
import { test, expect } from '@playwright/test';
import path from 'node:path';

/**
 * Spec ini punya dua tujuan sekaligus:
 * 1. Smoke test E2E dasar untuk tiap modul (Wisuda, Jurusan, Prodi, Kuota Prodi).
 * 2. Generator screenshot untuk docs/USER_MANUAL.md — setiap langkah penting
 *    disimpan sebagai file PNG bernomor urut di docs/screenshots/.
 *
 * Jalankan dengan: npm run test:e2e
 * (memerlukan database yang sudah di-migrate & di-seed, lihat docs/USER_MANUAL.md)
 */

const SCREENSHOT_DIR = path.join(process.cwd(), 'docs', 'screenshots');
const shot = (name) => path.join(SCREENSHOT_DIR, name);

async function dismissSweetAlert(page) {
    const popup = page.locator('.swal2-popup');
    if (await popup.isVisible().catch(() => false)) {
        await page.locator('.swal2-confirm').click();
        await popup.waitFor({ state: 'hidden' }).catch(() => {});
    }
}

test.describe.configure({ mode: 'serial' });

test('Home — halaman dashboard', async ({ page }) => {
    await page.goto('/');
    await expect(page.getByRole('heading', { name: 'Sistem Informasi Kuota Wisuda' })).toBeVisible();
    await page.screenshot({ path: shot('01-home.png') });
});

test.describe('Modul Wisuda', () => {
    test('daftar gelombang wisuda', async ({ page }) => {
        await page.goto('/wisuda');
        await expect(page.locator('#table')).toBeVisible();
        await expect(page.getByText('Wisuda Ke-1')).toBeVisible();
        await page.screenshot({ path: shot('02-wisuda-daftar.png') });
    });

    test('tambah gelombang wisuda baru', async ({ page }) => {
        await page.goto('/wisuda');
        await page.locator('#addButton').click();
        await expect(page.locator('#kt_modal_1')).toBeVisible();

        await page.locator('#kt_modal_1 select#jenis').selectOption('ONLINE');
        await page.locator('#kt_modal_1 input#date').fill('2026-12-20');
        await page.locator('#kt_modal_1 input#kuota').fill('500');
        await page.screenshot({ path: shot('03-wisuda-tambah-modal.png') });

        await page.locator('#kt_modal_1 button[type="submit"]').click();
        await page.waitForURL('**/wisuda');
        await dismissSweetAlert(page);

        const firstRow = page.locator('#table tbody tr').first();
        await expect(firstRow).toContainText('ONLINE');
        await page.screenshot({ path: shot('04-wisuda-daftar-setelah-tambah.png') });

        // Ikuti link "Edit Data" pada gelombang yang baru dibuat untuk screenshot berikutnya.
        // Link ini berada di dalam dropdown Actions yang tersembunyi (display:none) sampai
        // diklik, jadi dicari lewat locator teks biasa (bukan getByRole) supaya tidak
        // bergantung pada visibilitas/accessibility tree.
        const editHref = await firstRow.locator('a', { hasText: 'Edit Data' }).getAttribute('href');
        await page.goto(editHref);
        await expect(page.locator('input#kuota')).toHaveValue('500');
        await page.screenshot({ path: shot('05-wisuda-edit.png') });
    });
});

test.describe('Modul Kuota Prodi', () => {
    test('lihat & set kuota prodi untuk gelombang wisuda ke-1', async ({ page }) => {
        await page.goto('/kuota_prodi?gelombang_id=1');
        await expect(page.getByRole('heading', { name: /Kuota Prodi Wisuda Ke-1/ })).toBeVisible();
        await page.screenshot({ path: shot('06-kuota-prodi-daftar.png') });

        await page.locator('.setButton').first().click();
        await expect(page.locator('#kt_modal_1')).toBeVisible();
        await expect(page.locator('#kt_modal_1 input#kuota')).not.toHaveValue('');
        await page.screenshot({ path: shot('07-kuota-prodi-set-modal.png') });
    });
});

test.describe('Modul Jurusan', () => {
    test('daftar, tambah, dan edit jurusan', async ({ page }) => {
        await page.goto('/jurusan');
        await expect(page.getByText('TEKNOLOGI INFORMASI')).toBeVisible();
        await page.screenshot({ path: shot('08-jurusan-daftar.png') });

        // Modal tambah jurusan (diisi contoh, tidak disubmit agar data seed tetap utuh)
        await page.locator('#addButton').click();
        await expect(page.locator('#kt_modal_1')).toBeVisible();
        await page.locator('#kt_modal_1 input#nama').fill('TEKNIK MESIN');
        await page.screenshot({ path: shot('09-jurusan-tambah-modal.png') });
        await page.keyboard.press('Escape');
        await expect(page.locator('#kt_modal_1')).toBeHidden();

        // Modal edit jurusan — trigger langsung handler klik (tombol berada di dalam
        // dropdown Actions), data terisi lewat AJAX GET /jurusan/{id}/edit
        await page.locator('.edit').first().dispatchEvent('click');
        await expect(page.locator('#kt_modal_2')).toBeVisible();
        await expect(page.locator('#edit_nama')).toHaveValue('TEKNOLOGI INFORMASI');
        await page.screenshot({ path: shot('10-jurusan-edit-modal.png') });
    });
});

test.describe('Modul Program Studi (Prodi)', () => {
    test('daftar, tambah, dan edit prodi', async ({ page }) => {
        await page.goto('/prodi?jurusan_id=1');
        await expect(page.getByRole('heading', { name: /Manajemen Prodi Jurusan/ })).toBeVisible();
        await expect(page.getByText('D4 TEKNIK INFORMATIKA')).toBeVisible();
        await page.screenshot({ path: shot('11-prodi-daftar.png') });

        // Modal tambah prodi (diisi contoh, tidak disubmit agar data seed tetap utuh)
        await page.locator('#addButton').click();
        await expect(page.locator('#kt_modal_1')).toBeVisible();
        await page.locator('#kt_modal_1 select[name="jenjang"]').selectOption('D3');
        await page.locator('#kt_modal_1 input#nama').fill('TEKNIK PERANGKAT LUNAK');
        await page.screenshot({ path: shot('12-prodi-tambah-modal.png') });
        await page.keyboard.press('Escape');
        await expect(page.locator('#kt_modal_1')).toBeHidden();

        // Modal edit prodi — sama seperti Jurusan, trigger langsung handler klik
        await page.locator('.edit').first().dispatchEvent('click');
        await expect(page.locator('#kt_modal_2')).toBeVisible();
        await expect(page.locator('#edit_nama')).toHaveValue(/TEKNIK INFORMATIKA/);
        await page.screenshot({ path: shot('13-prodi-edit-modal.png') });
    });
});
