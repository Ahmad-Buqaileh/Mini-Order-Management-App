import { Component, Input, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProductResponse } from '../../services/product.service';
import { Store } from '@ngrx/store';
import * as ProductActions from '../../store/product.actions';

@Component({
  selector: 'app-product-card-component',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './product.card.component.html',
  styleUrls: ['./product.card.component.scss'],
})
export class ProductCardComponent {
  @Input() product!: ProductResponse;
  private userId = '019a9609-46d4-7086-9ae9-70c535157d96';

  constructor(private store: Store) {}

  quantity = signal(1);

  incrementQuantity() {
    this.quantity.update((quantity) => {
      const max = Math.min(15, this.product?.stock);
      return quantity < max ? quantity + 1 : max;
    });
  }
  decrementQuantity() {
    this.quantity.update((quantity) => (quantity > 1 ? quantity - 1 : 1));
  }

  addToCart() {
    if (!this.product || this.product.stock === 0) return;
    const qty = Math.min(this.quantity(), this.product.stock);
    this.store.dispatch(
      ProductActions.addProductToCart({
        productId: this.product.id,
        userId: this.userId,
        quantity: qty,
      })
    );
  }
}
