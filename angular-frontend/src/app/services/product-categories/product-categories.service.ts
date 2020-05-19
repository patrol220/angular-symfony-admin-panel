import {Injectable} from '@angular/core';
import {Sort} from '@angular/material/sort';
import {Observable} from 'rxjs';
import {ProductsResponseModel} from '../../models/Response/products-response.model';
import {HttpClient, HttpParams} from '@angular/common/http';
import {ProductsCategoriesResponseModel} from '../../models/Response/products-categories-response.model';
import {FilterModel} from '../../models/Request/filter.model';
import {ProductCategoryModel} from '../../models/product-category.model';
import {environment} from '../../../environments/environment';

const API_URL = environment.apiUrl;

@Injectable({
  providedIn: 'root'
})
export class ProductCategoriesService {

  constructor(private http: HttpClient) {
  }

  getCategories(
    page: number,
    pageSize: number,
    sort: Sort,
    filters: Array<FilterModel> = null,
    includes: Array<string> = null
  ): Observable<ProductsCategoriesResponseModel> {
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

    if (includes !== null) {
      includes.forEach((include: string) => {
        httpParams = httpParams.append('include', include);
      });
    }

    if (filters !== null) {
      filters.forEach((filter) => {
        httpParams = httpParams.append('filter[' + filter.key + ']', filter.value);
      });
    }

    const options = {
      params: httpParams
    };

    return this.http
      .get<ProductsCategoriesResponseModel>(API_URL + '/api/categories', options);
  }

  addCategory(name: string, parentCategory: ProductCategoryModel) {
    return this.http.post(API_URL + '/api/category', {
      name,
      parent_id: parentCategory.id
    });
  }
}
