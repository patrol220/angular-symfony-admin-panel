import {Component, OnInit} from '@angular/core';
import {ProductCategoriesService} from '../../services/product-categories/product-categories.service';
import {Sort} from '@angular/material/sort';
import {ProductCategoryModel} from '../../models/product-category.model';
import {ProductsCategoriesResponseModel} from '../../models/Response/products-categories-response.model';
import {PageEvent} from '@angular/material/paginator';
import {MatDialog} from '@angular/material/dialog';
import {AddCategoryDialogComponent} from './add-category-dialog/add-category-dialog.component';

@Component({
  selector: 'app-category-list',
  templateUrl: './category-list.component.html',
  styleUrls: ['./category-list.component.scss']
})
export class CategoryListComponent implements OnInit {

  public categories: ProductCategoryModel[];
  public page;
  public pageSize;
  public totalProductsCount;
  public isRequestProcessing;
  public sort;

  constructor(
      public productCategoriesService: ProductCategoriesService,
      public addCategoryDialog: MatDialog
  ) {
  }

  openAddCategoryDialog() {
    let dialogRef = this.addCategoryDialog.open(AddCategoryDialogComponent, {});
  }

  ngOnInit(): void {
    this.page = 0;
    this.pageSize = 20;
    this.sort = null;

    this.getCategories(this.page, this.pageSize, this.sort);
  }

  public getCategories(page: number, pageSize: number, sort: Sort) {
    this.isRequestProcessing = true;
    this.productCategoriesService.getCategories(page + 1, pageSize, sort)
      .subscribe((responseData: ProductsCategoriesResponseModel) => {
        if (responseData.data.length > 0) {
          this.categories = responseData.data;
          this.totalProductsCount = responseData.meta.pagination.total;
          this.isRequestProcessing = false;
        }
      });
  }

  paginatorEvent(event: PageEvent) {
    this.page = event.pageIndex;
    this.pageSize = event.pageSize;
    this.getCategories(this.page, this.pageSize, this.sort);
  }

  sortEvent(event: Sort) {
    this.sort = event;
    this.getCategories(this.page, this.pageSize, this.sort);
  }
}
