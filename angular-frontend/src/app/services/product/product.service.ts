import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {ProductModel} from '../../models/product.model';
import {Observable} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {ProductsResponseModel} from '../../models/Response/products-response.model';
import {Sort} from '@angular/material/sort';
import {environment} from '../../../environments/environment';
import {ProductResponseModel} from '../../models/Response/product-response.model';

const API_URL = environment.apiUrl;

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
      let sortParam = sort.direction === 'desc' ? '-' + sort.active : sort.active;
      httpParams = httpParams.append('sort', sortParam);
    }

    const includes = ['category'];
    includes.forEach((include) => {
      httpParams = httpParams.append('include', include);
    });

    const options = {
      params: httpParams
    };

    return this.http
      .get<ProductsResponseModel>(API_URL + '/api/products', options)
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

  getProduct(id: number): Observable<ProductResponseModel> {
    let httpParams = new HttpParams();

    const includes = ['category'];
    includes.forEach((include) => {
      httpParams = httpParams.append('include', include);
    });

    const options = {
      params: httpParams
    };

    return this.http.get<ProductResponseModel>(API_URL + `/api/product/${id}`, options);
  }

  deleteProduct(id: number): Observable<{}> {
    return this.http.delete(API_URL + `/api/product/${id}`);
  }

  addProduct(newProduct: ProductModel) {
    return this.http.post(API_URL + '/api/product', {
      name: newProduct.name,
      category_id: newProduct.category.data !== undefined ? newProduct.category.data.id : null,
      weight: newProduct.weight,
      price: newProduct.price
    });
  }
}
