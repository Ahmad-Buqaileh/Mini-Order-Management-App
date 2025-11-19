import { createReducer, on } from '@ngrx/store';
import {
  addProductToCart,
  addProductToCartFailure,
  addProductToCartSuccess,
  loadProducts,
  loadProductsFailure,
  loadProductsSuccess,
} from './product.actions';

export interface ProductState {
  products: any[];
  loading: boolean;
  error: any;
}

export const initialState: ProductState = {
  products: [],
  loading: false,
  error: null,
};

export const productReducer = createReducer(
  initialState,
  on(loadProducts, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loadProductsSuccess, (state, { products }) => ({
    ...state,
    products: products,
    loading: false, 
    error: null,
  })),
  on(loadProductsFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error: error,
  })),
  on(addProductToCart, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(addProductToCartSuccess, (state) => ({
    ...state,
    loading: false,
    error: null,
  })),
  on(addProductToCartFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error: error,
  }))
);
