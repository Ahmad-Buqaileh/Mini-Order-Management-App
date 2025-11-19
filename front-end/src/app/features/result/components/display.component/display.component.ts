import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Store } from '@ngrx/store';
import { ProductCardComponent } from '../product.card.component/product.card.component';
import { selectAllProducts } from '../../store/product.selectors';
import * as ProductActions from '../../store/product.actions';
import { ProductResponse } from '../../services/product.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-display-component',
  standalone: true,
  imports: [CommonModule, ProductCardComponent],
  templateUrl: './display.component.html',
  styleUrls: ['./display.component.scss'],
})
export class DisplayComponent implements OnInit {
  products$!: Observable<ProductResponse[]>;

  constructor(private store: Store) {}

  ngOnInit(): void {
    this.products$ = this.store.select(selectAllProducts);
    console.log('products$', this.products$);
    this.store.dispatch(ProductActions.loadProducts());
  }
}
