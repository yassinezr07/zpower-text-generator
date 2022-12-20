<?php


use KnpU\LoremIpsumBundle\KnpLoremIpsumBundle;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{


    public function testServiceWiring()
    {
        $kernel = new KnpLoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $ipsum = $container->get('knp_u_lorem_ipsum.knp_uipsum');
        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }

    public function testWiringWithConfiguration()
    {
        $kernel = new KnpLoremIpsumTestingKernel([
            'word_provider' => 'stub_word_list'
        ]);

        $kernel->boot();
        $container = $kernel->getContainer();
        $ipsum = $container->get('knp_u_lorem_ipsum.knp_uipsum');
        $this->assertStringContainsString('stub', $ipsum->getWords(2));
    }


}

class KnpLoremIpsumTestingKernel extends Kernel
{


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
            new KnpLoremIpsumBundle()
        ];
    }


    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);
            $container->loadFromExtension('knp_lorem_ipsum', $this->knpUIpsumConfig);
        });
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/cache/'.spl_object_hash($this);
    }

}

class StubWordList implements WordProviderInterface
{

    public function getWordList(): array
    {
       return ['stub', 'stub2'];
    }
}