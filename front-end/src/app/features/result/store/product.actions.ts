import { createAction, props } from '@ngrx/store';
import { ProductResponse } from '../services/product.service';
import { AddProductModel } from '../components/model/product.model';

export const loadProducts = createAction('[Product] Load Products');
export const loadProductsSuccess = createAction(
  '[Product] Load Products Success',
  props<{ products: ProductResponse[] }>()
);
export const loadProductsFailure = createAction(
  '[Product] Load Products Failure',
  props<{ error: any }>()
);

export const addProductToCart = createAction(
  '[Product] Add Product To Cart',
  props<AddProductModel>()
);
export const addProductToCartSuccess = createAction('[Product] Add Product To Cart Success');
export const addProductToCartFailure = createAction(
  '[Product] Add Product To Cart Failure',
  props<{ error: any }>()
);