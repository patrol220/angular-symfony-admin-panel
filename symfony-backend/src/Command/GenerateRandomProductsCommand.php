<?php

namespace App\Command;

use App\Entity\Product\Product;
use App\Entity\Product\ProductCategory;
use App\Repository\Product\ProductCategoryRepository;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomProductsCommand extends Command
{
    protected static $defaultName = 'app:generate-random-products';

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
        $this->setDescription('Generates 100000 random products');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Factory::create();

        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null); //For lower memory usage

        /** @var ProductCategoryRepository $categoriesRepository */
        $categoriesRepository = $this->entityManager->getRepository(ProductCategory::class);

        $categories = $categoriesRepository->findAll();

        $categoriesIds = array_map(
            function ($category) {
                return $category->getId();
            },
            $categories
        );

        for ($i = 0; $i < 100000; $i++) {
            $product = new Product();
            $product->setName($faker->text(40));
            $product->setCategory(
                $categoriesRepository->find($faker->randomElement($categoriesIds))
            );
            $product->setPrice($faker->numberBetween(2, 3000));

            $this->entityManager->persist($product);

            if ($i % 100 === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }
        return 0;
    }

}
