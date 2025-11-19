import { createReducer, on } from '@ngrx/store';
import { loadCartItems, loadCartItemsFailure, loadCartItemsSuccess } from './cart.actions';

export interface CartState {
  cartItems: any[];
  loading: boolean;
  error: any;
}

export const initialState: CartState = {
  cartItems: [],
  loading: false,
  error: null,
};

export const cartReducer = createReducer(
  initialState,
  on(loadCartItems, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loadCartItemsSuccess, (state, { cartItems }) => ({
    ...state,
    cartItems: cartItems,
    loading: false,
    error: null,
  })),
  on(loadCartItemsFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error: error,
  }))
);
