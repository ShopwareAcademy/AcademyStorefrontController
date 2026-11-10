import {expect, test} from './BaseTestFile';

test('displays the image modal link on a product detail page', async ({
    page,
    TestDataService,
    DefaultSalesChannel,
}) => {
    const basicProduct = await TestDataService.createBasicProduct();

    await page.goto(`${DefaultSalesChannel.url}/detail/${basicProduct.id}`);

    const openImageModalLink = page.locator('a.open-image-modal');

    await expect(openImageModalLink).toBeVisible();
});
