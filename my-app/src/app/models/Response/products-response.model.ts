import {ProductModel} from '../product.model';
import {PaginationModel} from './Common/pagination.model';

export interface ProductsResponseModel {
  data: ProductModel[];
  meta: {
    pagination: PaginationModel
  };
}
