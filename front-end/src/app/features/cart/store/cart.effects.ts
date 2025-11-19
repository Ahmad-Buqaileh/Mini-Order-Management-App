import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import * as CartActions from './cart.actions';
import { CartService } from '../services/cart.service';
import { catchError, map, mergeMap, of } from 'rxjs';

@Injectable()
export class CartEffects {
  loadCartItems$: any;
  createUserCart$: any;

  constructor(private actions$: Actions, private cartService: CartService) {
    this.loadCartItems$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.loadCartItems),
        mergeMap(() =>
          this.cartService.getCartItems('019a9609-46d4-7086-9ae9-70c535157d96').pipe(
            map((res: any) => CartActions.loadCartItemsSuccess({ cartItems: res.cartItems })),
            catchError((err) => of(CartActions.loadCartItemsFailure({ error: err.message })))
          )
        )
      )
    );

    this.createUserCart$ = createEffect(() =>
      this.actions$.pipe(
        ofType(CartActions.createUserCart),
        mergeMap(() =>
          this.cartService.createUserCart('019a9609-46d4-7086-9ae9-70c535157d96').pipe(
            map((res: any) => CartActions.createUserCartSuccess({ message: res.message })),
            catchError((err) => of(CartActions.createUserCartFailure({ error: err.message })))
          )
        )
      )
    );
  }
}
