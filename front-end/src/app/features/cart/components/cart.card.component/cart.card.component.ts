import { Component, Input, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CartItemResponse } from '../../services/cart.service';
import { Store } from '@ngrx/store';
import * as CartActions from '../../store/cart.actions';

@Component({
  selector: 'app-cart-card-component',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './cart.card.component.html',
  styleUrls: ['./cart.card.component.scss'],
})
export class CartCardComponent implements OnInit {
  @Input() cartItem!: CartItemResponse;
  private store = inject(Store);
  quantity = signal<number>(0);

  ngOnInit() {
    this.quantity.set(this.cartItem.quantity);
  }

  incrementQuantity() {
    const newQuantity = Math.min(15, Math.min(this.cartItem.product.stock, this.quantity() + 1));
    this.quantity.set(newQuantity);
    this.store.dispatch(
      CartActions.updateCartItemQuantity({ cartItemId: this.cartItem.id, quantity: newQuantity })
    );
  }

  decrementQuantity() {
    const newQuantity = Math.max(1, this.quantity() - 1);
    this.quantity.set(newQuantity);
    this.store.dispatch(
      CartActions.updateCartItemQuantity({ cartItemId: this.cartItem.id, quantity: newQuantity })
    );
  }

  removeItem() {
    if (confirm('Are you sure you want to remove this item from the cart?')) {
      this.store.dispatch(CartActions.removeCartItem({ cartItemId: this.cartItem.id }));
    }
  }
}
