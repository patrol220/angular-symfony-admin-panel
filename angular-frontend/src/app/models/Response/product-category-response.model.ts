export interface ProductCategoryResponseModel {
  id: number;
  name: string;
  parent: {
    data: ProductCategoryResponseModel
  };
}
