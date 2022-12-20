<?php


use http\Client;
use KnpU\LoremIpsumBundle\KnpLoremIpsumBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class IpsumApiControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $kernel = new KnpLoremIpsumControllerKernel();
        $client = new KernelBrowser($kernel);
        $client->request('GET', '/api/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

class KnpLoremIpsumControllerKernel extends Kernel
{

    use MicroKernelTrait;

    /**
     * @var array
     */
    private $knpUIpsumConfig;

    public function __construct(array $knpUIpsumConfig = [])
    {
        parent::__construct('test', true);
        $this->knpUIpsumConfig = $knpUIpsumConfig;
    }

    public function registerBundles(): array
    {
        return [
            new KnpLoremIpsumBundle(),
            new FrameworkBundle()
        ];
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/../cache/'.spl_object_hash($this);
    }

    protected function configureRoutes(RoutingConfigurator  $routes)
    {
        $routes->import(__DIR__. '/../../src/Resources/config/routes.xml')->prefix('/api');
    }
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
    }



}
