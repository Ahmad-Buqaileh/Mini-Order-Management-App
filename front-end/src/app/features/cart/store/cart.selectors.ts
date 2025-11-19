import { createSelector, createFeatureSelector } from '@ngrx/store';
import { CartState } from './cart.reducers';

export const selectCartState = createFeatureSelector<CartState>('cart');

export const selectCartItems = createSelector(selectCartState, (s) => s.cartItems);
export const selectCartLoading = createSelector(selectCartState, (s) => s.loading);
export const selectCartError = createSelector(selectCartState, (s) => s.error);
