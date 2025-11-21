import { createReducer, on } from '@ngrx/store';
import {
  loginUser,
  loginUserFailure,
  loginUserSuccess,
  refreshToken,
  refreshTokenFailure,
  registerUser,
  registerUserFailure,
  registerUserSuccess,
  logoutUser,
  logoutUserFailure,
  logoutUserSuccess,
  refreshTokenSuccess,
} from '../store/auth.actions';

export interface UserState {
  accessToken: any;
  loading: boolean;
  error: any;
}

export const initialState: UserState = {
  accessToken: null,
  loading: false,
  error: null,
};

export const authReducer = createReducer(
  initialState,
  on(loginUser, registerUser, logoutUser, refreshToken, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loginUserFailure, registerUserFailure, logoutUserFailure, refreshTokenFailure, (state, { error }) => ({
    ...state,
    accessToken: null,
    loading: false,
    error,
  })),
  on(loginUserSuccess, registerUserSuccess, refreshTokenSuccess, (state, { response }) => ({
    ...state,
    accessToken: response.accessToken,
    loading: false,
    error: null,
  })),
  on(logoutUserSuccess, (state) => ({
    ...state,
    accessToken: null,
    loading: false,
    error: null,
  }))
);
