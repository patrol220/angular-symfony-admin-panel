import {PaginationModel} from './Common/pagination.model';
import {ProductCategoryResponseModel} from './product-category-response.model';

export interface ProductsCategoriesResponseModel {
  data: ProductCategoryResponseModel[];
  meta: {
    pagination: PaginationModel;
  };
}
