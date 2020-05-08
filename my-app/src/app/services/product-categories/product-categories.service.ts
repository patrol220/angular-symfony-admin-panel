import {Injectable} from '@angular/core';
import {Sort} from '@angular/material/sort';
import {Observable} from 'rxjs';
import {ProductsResponseModel} from '../../models/Response/products-response.model';
import {HttpClient, HttpParams} from '@angular/common/http';
import {ProductsCategoriesResponseModel} from '../../models/Response/products-categories-response.model';
import {FilterModel} from '../../models/Request/filter.model';
import {ProductCategoryModel} from '../../models/product-category.model';

@Injectable({
  providedIn: 'root'
})
export class ProductCategoriesService {

  constructor(private http: HttpClient) {
  }

  getCategories(page: number, pageSize: number, sort: Sort, filters: FilterModel[] = null): Observable<ProductsCategoriesResponseModel> {
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

    if (filters !== null) {
      filters.forEach((filter) => {
        httpParams = httpParams.append('filter[' + filter.key + ']', filter.value);
      });
    }

    const options = {
      params: httpParams
    };

    return this.http
      .get<ProductsCategoriesResponseModel>('http://localhost:80/api/categories', options);
  }

  addCategory(name: string, parentCategory: ProductCategoryModel) {
    return this.http.post('http://localhost:80/api/category', {
      name,
      parent_id: parentCategory.id
    });
  }
}
