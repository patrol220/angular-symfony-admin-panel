export interface ProductModel {
  id: number;
  name: string;
  weight: number;
  price: number;
  category: {
    id: number;
    name: string;
  };
}
