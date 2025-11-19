import { Component, OnInit, Inject } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { CartCardComponent } from '../../components/cart.card.component/cart.card.component';
import { Store } from '@ngrx/store';
import { selectCartItems } from '../../store/cart.selectors';
import * as CartActions from '../../store/cart.actions';
import { map, Observable } from 'rxjs';
import { CartItemResponse } from '../../services/cart.service';
import { AsyncPipe, CommonModule } from '@angular/common';
import * as OrderActions from '../../../order/store/order.actions';

@Component({
  selector: 'app-cart.page',
  standalone: true,
  imports: [HeaderComponent, CartCardComponent, AsyncPipe, CommonModule],
  templateUrl: './cart.page.html',
  styleUrls: ['./cart.page.scss'],
})
export class CartPage implements OnInit {
  cartItems$!: Observable<CartItemResponse[]>;
  totalPrice$!: Observable<number>;
  private userId = '019a9609-46d4-7086-9ae9-70c535157d96';

  constructor(private store: Store) {
    this.totalPrice$ = this.store.select(selectCartItems).pipe(
      map((items) => items.reduce((total, item) => total + item.product.price * item.quantity, 0))
    );
  }

  ngOnInit(): void {
    this.store.dispatch(CartActions.loadCartItems());
    this.cartItems$ = this.store.select(selectCartItems);
  }

  handleSubmitOrder() {
    this.store.dispatch(
      OrderActions.createOrder({
        userId: this.userId,
      })
    );
  }
}
