import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import * as CartActions from './cart.actions';
import { CartService } from '../services/cart.service';
import { catchError, map, mergeMap, of } from 'rxjs';

@Injectable()
export class CartEffects {
  loadCartItems$: any;
  createUserCart$: any;
  updateCartItemQuantity$: any;
  removeCartItem$: any;

  constructor(private actions$: Actions, private cartService: CartService) {
    this.loadCartItems$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.loadCartItems),
        mergeMap(({ userToken }) =>
          this.cartService.getCartItems(userToken).pipe(
            map((res: any) => CartActions.loadCartItemsSuccess({ cartItems: res.cartItems })),
            catchError((err) => of(CartActions.loadCartItemsFailure({ error: err.message })))
          )
        )
      )
    );

    this.createUserCart$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.createUserCart),
        mergeMap(({ userToken }) =>
          this.cartService.createUserCart(userToken).pipe(
            map((res: any) => CartActions.createUserCartSuccess({ message: res.message })),
            catchError((err) => of(CartActions.createUserCartFailure({ error: err.message })))
          )
        )
      )
    );

    this.updateCartItemQuantity$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.updateCartItemQuantity),
        mergeMap(({ cartItemId, quantity }) =>
          this.cartService.updateCartItemQuantity(cartItemId, quantity).pipe(
            map((res: any) => CartActions.updateCartItemQuantitySuccess({ cartItem: res.cartItem })),
            catchError((err) =>
              of(CartActions.updateCartItemQuantityFailure({ error: err.message }))
            )
          )
        )
      )
    );

    this.removeCartItem$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.removeCartItem),
        mergeMap(({ cartItemId }) =>
          this.cartService.removeCartItem(cartItemId).pipe(
            map((res: any) => CartActions.removeCartItemSuccess({ cartItemId: res.cartItemId })),
            catchError((err) => of(CartActions.removeCartItemFailure({ error: err.message })))
          )
        )
      )
    );
  }
}
