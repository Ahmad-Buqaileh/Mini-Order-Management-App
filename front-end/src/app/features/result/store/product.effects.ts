import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import * as ProductActions from './product.actions';
import { ProductService } from '../services/product.service';
import { catchError, map, mergeMap, of } from 'rxjs';

@Injectable()
export class ProductsEffects {
  loadProducts$: any;
  addProductToCart$: any;

  constructor(private actions$: Actions, private productService: ProductService) {
    this.loadProducts$ = createEffect(() =>
      this.actions$.pipe(
        ofType(ProductActions.loadProducts),
        mergeMap(() =>
          this.productService.getProducts().pipe(
            map((res: any) => ProductActions.loadProductsSuccess({ products: res.products })),
            catchError((err) => of(ProductActions.loadProductsFailure({ error: err.message })))
          )
        )
      )
    );

    this.addProductToCart$ = createEffect(() =>
      this.actions$.pipe(
        ofType(ProductActions.addProductToCart),
        mergeMap(({ productId, userToken, quantity }) =>
          this.productService.addProductToCart({ productId, userToken, quantity }).pipe(
            map(() => ProductActions.addProductToCartSuccess()),
            catchError((err) => of(ProductActions.addProductToCartFailure({ error: err.message })))
          )
        )
      )
    );
  }
}
