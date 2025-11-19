import { createSelector, createFeatureSelector } from '@ngrx/store';
import { ProductState } from './product.reducers';


export const selectProductState = createFeatureSelector<ProductState>('products');

export const selectAllProducts = createSelector(selectProductState, (s) => s.products);
export const selectProductsLoading = createSelector(selectProductState, (s) => s.loading);
export const selectProductsError = createSelector(selectProductState, (s) => s.error);

export const selectAddProductToCartLoading = createSelector(
    selectProductState,
    (s) => s.loading
);
export const selectAddProductToCartError = createSelector(
    selectProductState,
    (s) => s.error
);
