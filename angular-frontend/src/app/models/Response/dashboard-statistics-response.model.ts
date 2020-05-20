import {ProductModel} from '../product.model';

export interface DashboardStatisticsResponseModel {
  products: {
    count: number;
    new: {
      data: ProductModel[]
    };
  };
}
