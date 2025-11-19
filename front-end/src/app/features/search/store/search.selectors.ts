import { createSelector, createFeatureSelector } from '@ngrx/store';
import { SearchState } from './search.reducers';

export const selectSearchState = createFeatureSelector<SearchState>('search');
export const selectSearchResults = createSelector(selectSearchState, (state) => state.results);
export const selectSearchLoading = createSelector(selectSearchState, (state) => state.loading);
export const selectSearchError = createSelector(selectSearchState, (state) => state.error);

