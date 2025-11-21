import { createSelector } from '@ngrx/store';
import { UserState } from './auth.reducers';

export const selectUserState = (state: any): UserState =>
  state.auth || { accessToken: null, loading: false, error: null };

export const selectUserToken = createSelector(selectUserState, (s) => s.accessToken);
export const selectUserError = createSelector(selectUserState, (s) => s.error);
export const selectUserLoading = createSelector(selectUserState, (s) => s.loading);
