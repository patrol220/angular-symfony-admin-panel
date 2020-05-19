<?php

namespace App\Controller;

use App\Dto\Request\Factory\FiltersDtoFactory;
use App\Dto\Request\Factory\IncludesDtoFactory;
use App\Dto\Request\Factory\PaginationDtoFactory;
use App\Dto\Request\Factory\SortDtoFactory;
use App\Service\ProductCategoryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductCategoryController extends AbstractController
{

    /**
     * @Route("api/categories", name="get_categories", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getCategories(Request $request, ProductCategoryService $categoryService): JsonResponse
    {
        $paginationDto = PaginationDtoFactory::createFromRequest($request);
        $sortDto = SortDtoFactory::createFromRequest();
        $filtersDto = FiltersDtoFactory::createFromRequest($request);
        $includes = IncludesDtoFactory::createFromRequest($request);

        return new JsonResponse(
            $categoryService->getPaginatedCategories($paginationDto, $sortDto, $filtersDto, $includes),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("api/category", name="add_category", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function addCategory(Request $request, ProductCategoryService $categoryService)
    {
        $requestContent = json_decode($request->getContent(), true);

        $categoryName = $requestContent['name'];
        $categoryParentId = isset($requestContent['parent_id']) ? $requestContent['parent_id'] : null;

        return new JsonResponse(
            $categoryService->addCategory($categoryName, $categoryParentId),
            Response::HTTP_CREATED
        );
    }
}
