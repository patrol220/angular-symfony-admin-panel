<?php

namespace App\Command;

use App\Entity\Product\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    private $productService;
    private $entityManager;

    public function __construct(ProductService $productService, EntityManagerInterface $entityManager)
    {
        $this->productService = $productService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Just a sandbox command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $faker = Factory::create();
//        $this->entityManager->getConfiguration()->setSQLLogger(null);
//        for($i = 0; $i < 1000000; $i++) {
//            $product = new Product();
//            $product->setName($faker->name);
//            $product->setWeight($faker->randomFloat(10, 0, 1000));
//            $product->setPrice($faker->randomFloat(10, 0, 10000));
//            $this->entityManager->persist($product);
//            $this->entityManager->flush();
//        }

        /** @var Product $product */
        $product = $this->entityManager->getRepository(Product::class)->find(1);


        return 0;
    }

}
