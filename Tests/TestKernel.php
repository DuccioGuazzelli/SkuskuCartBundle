<?php

namespace GGGGino\SkuskuCartBundle\Tests;

use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    private $useJMS;
    private $useBazinga;

    public function __construct(bool $useJMS = false, bool $useBazinga = false)
    {
        parent::__construct('test'.(int) $useJMS.(int) $useBazinga, true);

        $this->useJMS = $useJMS;
        $this->useBazinga = $useBazinga;
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new TwigBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new SensioFrameworkExtraBundle(),
            new \Craue\FormFlowBundle\CraueFormFlowBundle(),
            new \Payum\Bundle\PayumBundle\PayumBundle(),
            new \GGGGino\SkuskuCartBundle\GGGGinoSkuskuCartBundle(),
            new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle()
        ];

        if ($this->useJMS) {
            $bundles[] = new JMSSerializerBundle();

            if ($this->useBazinga) {
                $bundles[] = new BazingaHateoasBundle();
            }
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(dirname(__DIR__.'/Controller/CartController.php'), '/', 'annotation');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->loadFromExtension('framework', [
            'secret' => 'MySecretKey',
            'test' => null,
            'validation' => null,
            'form' => null,
            'templating' => [
                'engines' => ['twig'],
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return parent::getCacheDir().'/'.(int) $this->useJMS;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return parent::getLogDir().'/'.(int) $this->useJMS;
    }

    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/app/config/config.yml');
    }

    public function serialize()
    {
        return serialize($this->useJMS);
    }

    public function unserialize($str)
    {
        $this->__construct(unserialize($str));
    }
}