export interface ProductModel {
  id: number;
  name: string;
  weight: number;
  price: number;
  category: {
    data: {
      id: number;
      name: string;
    }
  };
  created: Date;
  updated: Date;
}
