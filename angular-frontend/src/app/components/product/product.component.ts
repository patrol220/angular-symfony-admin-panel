import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, ParamMap} from '@angular/router';
import {switchMap} from 'rxjs/operators';
import {ProductService} from '../../services/product/product.service';
import {ProductModel} from '../../models/product.model';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {

  public product: ProductModel;

  constructor(private route: ActivatedRoute, private productService: ProductService) {
  }

  ngOnInit(): void {
    this.route.paramMap.pipe(
      switchMap(
        (params: ParamMap) => this.productService.getProduct(Number(params.get('id')))
      )
    ).subscribe((responseData: ProductModel) => {
      this.product = responseData;
    });
  }

}
