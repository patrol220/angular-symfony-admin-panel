import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {ProductModel} from '../../models/product.model';
import {Observable} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {ProductsResponseModel} from '../../models/Response/products-response.model';
import {Sort} from '@angular/material/sort';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  constructor(private http: HttpClient) {
  }

  getProducts(page: number, pageSize: number, sort: Sort): Observable<ProductsResponseModel> {
    let httpParams = new HttpParams();

    if (page !== null) {
      httpParams = httpParams.append('page[number]', page.toString());
    }

    if (pageSize !== null) {
      httpParams = httpParams.append('page[size]', pageSize.toString());
    }

    if (sort !== null) {
      const sortParam = sort.direction === 'desc' ? '-' + sort.active : sort.active;
      httpParams = httpParams.append('sort', sortParam);
    }

    const options = {
      params: httpParams
    };

    return this.http
      .get<ProductsResponseModel>('http://localhost:80/api/products', options)
      .pipe(
        map(response => {
          response.data.map(value => {
            value.created = new Date(value.created);
            value.updated = new Date(value.updated);
          });
          return response;
        })
      );
  }

  getProduct(id: number): Observable<ProductModel> {
    return this.http.get<ProductModel>(`http://localhost:80/api/product/${id}`);
  }

  deleteProduct(id: number): Observable<{}> {
    return this.http.delete(`http://localhost:80/api/product/${id}`);
  }

  addProduct(newProduct: ProductModel) {
    return this.http.post('http://localhost:80/api/product', {
      name: newProduct.name,
      category_id: newProduct.category !== null ? newProduct.category.id : null,
      weight: newProduct.weight,
      price: newProduct.price
    });
  }

  addProductImage(file: File, productId: number) {
    // const formData: FormData = new FormData();
    // formData.append('file_key', file);
    // formData.append('product_id', productId.toString());

    return this.http.post('http://localhost:80/api/product-image', {}, {

    });
  }
}
