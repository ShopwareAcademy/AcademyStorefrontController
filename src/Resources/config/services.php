<?php declare(strict_types=1);

use Shopware\Core\System\SystemConfig\SystemConfigService;
use ShopwareAcademy\StorefrontController\Storefront\Controller\ImageController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ImageController::class)
        ->public()
        ->args([
            service(HttpClientInterface::class),
            service(SystemConfigService::class),
        ])
        ->call('setContainer', [service('service_container')]);
};
