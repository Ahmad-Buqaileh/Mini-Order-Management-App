import { createAction, props } from '@ngrx/store';
import { CartItemResponse } from '../services/cart.service';

export const loadCartItems = createAction(' [Cart] Load Cart Items', props<{ userToken: string }>());
export const loadCartItemsSuccess = createAction(
  '[Cart] Load Cart Items Success',
  props<{ cartItems: CartItemResponse[] }>()
);
export const loadCartItemsFailure = createAction(
  '[Cart] Load Cart Items Failure',
  props<{ error: any }>()
);

export const createUserCart = createAction('[Cart] Create User Cart', props<{ userToken: string }>());
export const createUserCartSuccess = createAction(
  '[Cart] Create User Cart Success',
  props<{ message: string }>()
);
export const createUserCartFailure = createAction(
  '[Cart] Create User Cart Failure',
  props<{ error: any }>()
);

export const updateCartItemQuantity = createAction(
  '[Cart] Update Cart Item Quantity',
  props<{ cartItemId: string; quantity: number }>()
);
export const updateCartItemQuantitySuccess = createAction(
  '[Cart] Update Cart Item Quantity Success',
  props<{ cartItem: CartItemResponse }>()
);
export const updateCartItemQuantityFailure = createAction(
  '[Cart] Update Cart Item Quantity Failure',
  props<{ error: any }>()
);

export const removeCartItem = createAction(
  '[Cart] Remove Cart Item',
  props<{ cartItemId: string }>()
);
export const removeCartItemSuccess = createAction(
  '[Cart] Remove Cart Item Success',
  props<{ cartItemId: string }>()
);
export const removeCartItemFailure = createAction(
  '[Cart] Remove Cart Item Failure',
  props<{ error: any }>()
);
