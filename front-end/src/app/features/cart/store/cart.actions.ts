import { createAction, props } from '@ngrx/store';
import { CartItemResponse } from '../services/cart.service';

export const loadCartItems = createAction(' [Cart] Load Cart Items');
export const loadCartItemsSuccess = createAction(
  '[Cart] Load Cart Items Success',
  props<{ cartItems: CartItemResponse[] }>()
);
export const loadCartItemsFailure = createAction(
  '[Cart] Load Cart Items Failure',
  props<{ error: any }>()
);

export const createUserCart = createAction('[Cart] Create User Cart');
export const createUserCartSuccess = createAction(
  '[Cart] Create User Cart Success',
  props<{ message: string }>()
);
export const createUserCartFailure = createAction(
  '[Cart] Create User Cart Failure',
  props<{ error: any }>()
);
