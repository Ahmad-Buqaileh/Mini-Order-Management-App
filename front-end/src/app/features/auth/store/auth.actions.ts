import { createAction, props } from '@ngrx/store';
import { AuthResponse } from '../services/auth.service';
import { LoginModel } from '../models/login.model';
import { RegisterModel } from '../models/register.model';

export const registerUser = createAction(
  '[Auth] Register User',
  props<{ credentials: RegisterModel }>()
);
export const registerUserSuccess = createAction(
  '[Auth] Register Success',
  props<{ response: AuthResponse }>()
);
export const registerUserFailure = createAction('[Auth] Register Failure', props<{ error: any }>());

export const loginUser = createAction('[Auth] Login User', props<{ credentials: LoginModel }>());
export const loginUserSuccess = createAction(
  '[Auth] Login Success',
  props<{ response: AuthResponse }>()
);
export const loginUserFailure = createAction('[Auth] Login Failure', props<{ error: any }>());

export const logoutUser = createAction('[Auth] Logout User');
export const logoutUserSuccess = createAction('[Auth] Logout Success');
export const logoutUserFailure = createAction('[Auth] Logout Failure', props<{ error: any }>());

export const refreshToken = createAction('[Auth] Refresh Token');
export const refreshTokenSuccess = createAction(
  '[Auth] Refresh Token Success',
  props<{ response: AuthResponse }>()
);
export const refreshTokenFailure = createAction(
  '[Auth] Refresh Token Failure',
  props<{ error: any }>()
);
