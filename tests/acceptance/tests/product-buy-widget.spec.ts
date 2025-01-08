import {expect, test} from './BaseTestFile';

function wait(ms: number): Promise<void> {
    return new Promise(resolve => setTimeout(resolve, ms));
}

test('Plugin test scenario.', async ({page, TestDataService, DefaultSalesChannel}) => {

    // Create a basic product
    const basicProduct = await TestDataService.createBasicProduct();

    // Open the product detail page
    await page.goto(`${DefaultSalesChannel.url}/detail/${basicProduct.id}`);

    // Wait for the page to load and check for a link with the class "open-image-modal"
    const openImageModalLink = page.locator('a.open-image-modals');

    await expect(openImageModalLink).toHaveCount(1);
});
