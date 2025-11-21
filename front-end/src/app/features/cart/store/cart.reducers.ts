import { createReducer, on } from '@ngrx/store';
import {
  loadCartItems,
  loadCartItemsFailure,
  loadCartItemsSuccess,
  removeCartItem,
  removeCartItemFailure,
  removeCartItemSuccess,
  updateCartItemQuantity,
  updateCartItemQuantityFailure,
  updateCartItemQuantitySuccess,
} from './cart.actions';

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
  })),
  on(updateCartItemQuantity, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(updateCartItemQuantitySuccess, (state, { cartItem }) => ({
    ...state,
    cartItems: state.cartItems.map((item) =>
      item.id === cartItem.id ? cartItem : item
    ),
    loading: false,
    error: null,
  })),
  on(updateCartItemQuantityFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error: error,
  })),
  on(removeCartItem, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(removeCartItemSuccess, (state, { cartItemId }) => ({
    ...state,
    cartItems: state.cartItems.filter((item) => item.id !== cartItemId),
    loading: false,
    error: null,
  })),
  on(removeCartItemFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error: error,
  }))
);
