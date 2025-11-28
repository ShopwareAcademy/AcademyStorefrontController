<?php declare(strict_types=1);

namespace ShopwareAcademy\StorefrontController\Storefront\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Controller\StorefrontController;

#[Route(defaults: ['_routeScope' => ['storefront'], 'XmlHttpRequest' => true])]
class ImageController extends StorefrontController
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SystemConfigService $systemConfigService
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route(
        path: '/image',
        name: 'frontend.image.show',
        methods: ['GET']
    )]
    public function showImage(SalesChannelContext $context): Response
    {
        $pluginConfig = $this->systemConfigService->get('AcademyStorefrontController.config', $context->getSalesChannelId());
        $apiAccessKey = $pluginConfig['apiAccessKey'];
        $apiProvider = $pluginConfig['apiProvider'];

        $response = $this->client->request(
            'GET',
            'https://api.' . $apiProvider . '.com/v1/images/search',
            [
                'headers' => [
                    'x-api-key' => $apiAccessKey
                ]
            ]
        );

        $data = $response->toArray();
        $imageUrl = $data[0]['url'];

        return $this->renderStorefront('@AcademyStorefrontController/storefront/page/image.html.twig', [
            'imageUrl' => $imageUrl
        ]);
    }
}
