import {Component, EventEmitter, OnInit} from '@angular/core';
import {MatDialogRef} from '@angular/material/dialog';
import {FormBuilder, FormControl, FormGroup} from '@angular/forms';
import {ProductService} from '../../../services/product/product.service';
import {FilterModel} from '../../../models/Request/filter.model';
import {ProductsCategoriesResponseModel} from '../../../models/Response/products-categories-response.model';
import {ProductCategoriesService} from '../../../services/product-categories/product-categories.service';
import {ProductCategoryModel} from '../../../models/product-category.model';
import {debounce} from 'lodash';
import {ProductModel} from '../../../models/product.model';
import {NotificationsService} from 'angular2-notifications';

@Component({
  selector: 'app-add-product-dialog',
  templateUrl: './add-product-dialog.component.html',
  styleUrls: ['./add-product-dialog.component.scss']
})
export class AddProductDialogComponent implements OnInit {

  addProductForm: FormGroup;
  categoryAutocomplete: ProductCategoryModel[];
  formControl = new FormControl();
  onAdd = new EventEmitter();

  constructor(
    public dialogRef: MatDialogRef<AddProductDialogComponent>,
    public formBuilder: FormBuilder,
    public productService: ProductService,
    public productCategoriesService: ProductCategoriesService,
    public notificationsService: NotificationsService
  ) {
    this.addProductForm = formBuilder.group({
      name: null,
      weight: null,
      price: null,
      category: null,
    });
  }

  ngOnInit(): void {
    this.categoryInput = debounce(this.categoryInput, 500);
  }

  onExitClick() {
    this.dialogRef.close();
  }

  onSubmit(newProduct: ProductModel) {
    this.productService.addProduct(newProduct)
      .subscribe(() => {
        this.dialogRef.close();
        this.notificationsService.success('Success!', 'Product successfully added');
        this.onAdd.emit();
      });
  }

  categoryInput(inputValue) {

    let filters: FilterModel[] = [{
      key: 'name',
      value: inputValue
    }];

    this.productCategoriesService.getCategories(1, 10, null, filters)
      .subscribe((responseData: ProductsCategoriesResponseModel) => {
        this.categoryAutocomplete = responseData.data;
      });
  }

  displayAutocompleteOption(category: ProductCategoryModel) {
    return category && category.name ? category.name : '';
  }
}
