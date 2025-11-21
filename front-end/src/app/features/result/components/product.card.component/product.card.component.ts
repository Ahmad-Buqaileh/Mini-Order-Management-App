import { Component, Input, signal, inject, DestroyRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProductResponse } from '../../services/product.service';
import { Store } from '@ngrx/store';
import * as ProductActions from '../../store/product.actions';
import { selectUserToken } from '../../../auth/store/auth.selectors';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  selector: 'app-product-card-component',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './product.card.component.html',
  styleUrls: ['./product.card.component.scss'],
})
export class ProductCardComponent {
  @Input() product!: ProductResponse;
  private store = inject(Store);
  private destroyRef = inject(DestroyRef);
  userToken$ = this.store.select(selectUserToken);
  userToken!: string | null;

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
    this.userToken$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((token) => {
      if(token) {
        this.userToken = token;
      }
    });
    if (!this.product || this.product.stock === 0) {
      return;
    }
    if (!this.userToken) {
      return;
    }
    console.log('User token in addToCart:', this.userToken);
    const qty = Math.min(this.quantity(), this.product.stock);
    this.store.dispatch(
      ProductActions.addProductToCart({
        productId: this.product.id,
        userToken: this.userToken,
        quantity: qty,
      })
    );
  }
}
