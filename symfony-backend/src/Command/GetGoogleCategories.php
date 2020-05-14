<?php

namespace App\Command;

use App\Entity\Product\ProductCategory;
use App\Repository\Product\ProductCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetGoogleCategories extends Command
{
    const GOOGLE_TAXONOMY_XLS_FILE = 'http://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.xls';
    protected static $defaultName = 'app:get-google-categories';

    private $entityManager;
    private $productCategoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductCategoryRepository $productCategoryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productCategoryRepository = $productCategoryRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Fills categories with google ones');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tmpfile = tmpfile();
        fwrite(
            $tmpfile,
            file_get_contents(self::GOOGLE_TAXONOMY_XLS_FILE)
        );

        $spreadsheet = IOFactory::load(stream_get_meta_data($tmpfile)['uri']);

        $googleCategories = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < 7; $i++) {
            if ($i === 1) {
                $mainCategories = array_map(
                    function ($category) {
                        return $category[1];
                    },
                    $googleCategories
                );

                $mainCategories = array_values(array_unique($mainCategories));

                foreach ($mainCategories as $mainCategory) {
                    if (!$this->categoryExists($mainCategory, null)) {
                        $category = new ProductCategory();
                        $category->setName($mainCategory);
                        $this->entityManager->persist($category);
                    }
                }
                $this->entityManager->flush();
            } else {
                $subCategories = [];

                foreach ($googleCategories as $googleCategory) {
                    if (!in_array($googleCategory[$i], array_column($subCategories, 1))) {
                        $subCategories[] = [$googleCategory[$i - 1], $googleCategory[$i]];
                    }
                }

                foreach ($subCategories as $subCategory) {
                    $parentCategory = $this->productCategoryRepository->findOneBy(
                        [
                            'name' => $subCategory[0]
                        ]
                    );

                    if ($subCategory[1] !== null && !$this->categoryExists($subCategory[1], $parentCategory)) {
                        $category = new ProductCategory();
                        $category->setName($subCategory[1]);
                        $category->setParent($parentCategory);
                        $this->entityManager->persist($category);
                    }
                }
                $this->entityManager->flush();
            }
        }
        return 0;
    }

    private function categoryExists($name, ?ProductCategory $parentCategory): bool
    {
        $category = $this->productCategoryRepository->findOneBy(
            [
                'name' => $name,
                'parent' => $parentCategory
            ]
        );

        return $category === null ? false : true;
    }

}
