import {Component, OnInit} from '@angular/core';
import {MatDialogRef} from '@angular/material/dialog';
import {ProductCategoryModel} from '../../../models/product-category.model';
import {ProductCategoriesService} from '../../../services/product-categories/product-categories.service';
import {ProductsCategoriesResponseModel} from '../../../models/Response/products-categories-response.model';
import {FormBuilder, FormControl, FormGroup} from '@angular/forms';
import {FilterModel} from '../../../models/Request/filter.model';
import {debounce} from 'lodash';
import {NotificationsService} from 'angular2-notifications';

@Component({
  selector: 'app-add-category-dialog',
  templateUrl: './add-category-dialog.component.html',
  styleUrls: ['./add-category-dialog.component.scss']
})
export class AddCategoryDialogComponent implements OnInit {

  public addCategoryForm: FormGroup;
  public parentCategoryAutocomplete: ProductCategoryModel[];
  public formControl = new FormControl();

  constructor(
    public dialogRef: MatDialogRef<AddCategoryDialogComponent>,
    public productCategoriesService: ProductCategoriesService,
    public formBuilder: FormBuilder,
    public notificationsService: NotificationsService
  ) {
    this.addCategoryForm = formBuilder.group({
      name: '',
      parentCategory: ''
    });
  }

  ngOnInit() {
    this.parentCategoryInput = debounce(this.parentCategoryInput, 500);
  }

  onExitClick() {
    this.dialogRef.close();
  }

  displayAutocompleteOption(category: ProductCategoryModel): string {
    return category && category.name ? category.name : '';
  }

  onSubmit(newCategory) {
    this.productCategoriesService.addCategory(newCategory.name, newCategory.parentCategory)
      .subscribe(() => {
        this.dialogRef.close();
        this.notificationsService.success('Success!', 'Category successfully added');
      });
  }

  parentCategoryInput(inputValue) {

    let filters: FilterModel[] = [{
      key: 'name',
      value: inputValue
    }];

    this.productCategoriesService.getCategories(1, 10, null, filters)
      .subscribe((responseData: ProductsCategoriesResponseModel) => {
        this.parentCategoryAutocomplete = responseData.data;
      });
  }
}
