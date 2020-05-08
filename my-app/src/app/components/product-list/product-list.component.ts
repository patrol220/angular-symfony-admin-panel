import {Component, OnInit} from '@angular/core';
import {ProductService} from '../../services/product/product.service';
import {ProductModel} from '../../models/product.model';
import {ProductsResponseModel} from '../../models/Response/products-response.model';
import {CursorModel} from '../../models/Response/Common/cursor.model';
import {PageEvent} from '@angular/material/paginator';
import {Sort} from '@angular/material/sort';
import {MatDialog} from '@angular/material/dialog';
import {AddProductDialogComponent} from './add-product-dialog/add-product-dialog.component';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit {

  public products: ProductModel[];
  public page;
  public pageSize;
  public totalProductsCount;
  public isRequestProcessing;
  public sort;

  constructor(
    private productService: ProductService,
    private addProductDialog: MatDialog
  ) {
    this.page = 0;
    this.pageSize = 20;
    this.sort = null;
  }

  ngOnInit(): void {
    this.getProducts(this.page, this.pageSize);
  }

  getProducts(page: number, pageSize: number, sort: Sort = null): void {
    this.isRequestProcessing = true;
    this.productService
      .getProducts(page + 1, pageSize, sort)
      .subscribe((responseData: ProductsResponseModel) => {
        if (responseData.data.length > 0) {
          this.products = responseData.data;
          this.totalProductsCount = responseData.meta.pagination.total;
          this.isRequestProcessing = false;
        }
      });
  }

  delete(productId: number): void {
    this.productService.deleteProduct(productId)
      .subscribe((response) => {
        this.getProducts(this.page, this.pageSize, this.sort);
      });
  }

  paginatorEvent(event: PageEvent) {
    this.page = event.pageIndex;
    this.pageSize = event.pageSize;
    this.getProducts(this.page, this.pageSize, this.sort);
  }

  sortEvent(event: Sort) {
    this.sort = event;
    this.getProducts(this.page, this.pageSize, this.sort);
  }

  openAddProductDialog() {
    let dialogRef = this.addProductDialog.open(AddProductDialogComponent);
  }
}
