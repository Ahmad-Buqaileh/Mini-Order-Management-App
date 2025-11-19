import { createAction, props } from '@ngrx/store';
import { ProductResponse } from '../../result/services/product.service';

export const loadSearchResults = createAction(
  '[Search] Load Search Results',
  props<{ query: string }>()
);

export const loadSearchResultsSuccess = createAction(
  '[Search] Load Search Results Success',
  props<{ results: ProductResponse[] }>()
);

export const loadSearchResultsFailure = createAction(
  '[Search] Load Search Results Failure',
  props<{ error: any }>()
);

export const loadCategoryResults = createAction(
  '[Search] Load Category Results',
  props<{ category: string }>()
);

export const loadCategoryResultsSuccess = createAction(
  '[Search] Load Category Results Success',
  props<{ results: ProductResponse[] }>()
);

export const loadCategoryResultsFailure = createAction(
  '[Search] Load Category Results Failure',
  props<{ error: any }>()
);
