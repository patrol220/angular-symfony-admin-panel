import {ProductCategoryModel} from '../product-category.model';
import {PaginationModel} from './Common/pagination.model';

export interface ProductsCategoriesResponseModel {
  data: ProductCategoryModel[];
  meta: {
    pagination: PaginationModel;
  };
}
