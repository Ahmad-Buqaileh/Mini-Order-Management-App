import { createReducer, on } from '@ngrx/store';
import {
  loadSearchResults,
  loadSearchResultsFailure,
  loadSearchResultsSuccess,
  loadCategoryResults,
  loadCategoryResultsFailure,
  loadCategoryResultsSuccess,
} from './search.actions';
import { ProductResponse } from '../../result/services/product.service';

export interface SearchState {
  results: ProductResponse[];
  loading: boolean;
  error: any;
}

export const initialState: SearchState = {
  results: [],
  loading: false,
  error: null,
};

export const searchReducer = createReducer(
  initialState,
  on(loadSearchResults, loadCategoryResults, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loadSearchResultsSuccess, loadCategoryResultsSuccess, (state, { results }) => ({
    ...state,
    results,
    loading: false,
    error: null,
  })),
  on(loadSearchResultsFailure, loadCategoryResultsFailure, (state, { error }) => ({
    ...state,
    results: [],
    loading: false,
    error,
  }))
);
