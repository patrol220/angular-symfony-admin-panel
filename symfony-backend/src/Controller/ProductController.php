<?php

namespace App\Controller;

use App\Dto\Product\Factory\ProductDtoFactory;
use App\Dto\Request\Factory\IncludesDtoFactory;
use App\Dto\Request\Factory\PaginationDtoFactory;
use App\Dto\Request\Factory\SortDtoFactory;
use App\Exception\ItemNotFoundInDatabaseException;
use App\Service\ProductService;
use Elastica\Processor\Json;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("api/products", name="get_products", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getProducts(Request $request, ProductService $productService): Response
    {
        $paginationDto = PaginationDtoFactory::createFromRequest($request);
        $sortDto = SortDtoFactory::createFromRequest();
        $includes = IncludesDtoFactory::createFromRequest($request);

        return new JsonResponse(
            $productService->getPaginatedProducts($paginationDto, $sortDto, $includes),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("api/product/{id}", name="get_product", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getProduct(Request $request, $id, ProductService $productService): Response
    {
        $includes = IncludesDtoFactory::createFromRequest($request);
        return new JsonResponse($productService->getProduct($id, $includes));
    }

    /**
     * @Route("api/product/{id}", name="delete_product", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteProduct($id, ProductService $productService): Response
    {
        try {
            $productService->deleteProduct($id);
        } catch (ItemNotFoundInDatabaseException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\TypeError $exception) {
            return new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new Response(null, Response::HTTP_OK);
    }

    /**
     * @Route("api/product", name="add_product", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function addProduct(Request $request, ProductService $productService): JsonResponse
    {
        $productDto = ProductDtoFactory::createFromRequest($request);

        return new JsonResponse(
            $productService->addProduct($productDto),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("api/products/statistics", name="products_statistics", methods={"GET"})
     */
    public function getProductsStatistics(ProductService $productService)
    {
        return new JsonResponse($productService->getProductsStatistics());
    }
}
