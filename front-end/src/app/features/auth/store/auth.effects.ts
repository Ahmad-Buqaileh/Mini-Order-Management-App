import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import * as AuthActions from '../store/auth.actions';
import { AuthService } from '../services/auth.service';
import { catchError, map, mergeMap, of } from 'rxjs';
import { AuthResponse } from '../services/auth.service';

@Injectable()
export class AuthEffects {
  loginUser$: any;
  registerUser$: any;
  logoutUser$: any;
  refreshToken$: any;

  constructor(private actions$: Actions, private authService: AuthService) {
    this.loginUser$ = createEffect(() =>
      this.actions$.pipe(
        ofType(AuthActions.loginUser),
        mergeMap(({ credentials }) =>
          this.authService.login(credentials).pipe(
            map((response: AuthResponse) => AuthActions.loginUserSuccess({ response })),
            catchError((error) => of(AuthActions.loginUserFailure({ error })))
          )
        )
      )
    );

    this.registerUser$ = createEffect(() =>
      this.actions$.pipe(
        ofType(AuthActions.registerUser),
        mergeMap(({ credentials }) =>
          this.authService.register(credentials).pipe(
            map((response: AuthResponse) => AuthActions.registerUserSuccess({ response })),
            catchError((error) => of(AuthActions.registerUserFailure({ error })))
          )
        )
      )
    );

    this.logoutUser$ = createEffect(() =>
      this.actions$.pipe(
        ofType(AuthActions.logoutUser),
        mergeMap(() =>
          this.authService.logout().pipe(
            map(() => AuthActions.logoutUserSuccess()),
            catchError((error) => of(AuthActions.logoutUserFailure({ error })))
          )
        )
      )
    );

    this.refreshToken$ = createEffect(() =>
      this.actions$.pipe(
        ofType(AuthActions.refreshToken),
        mergeMap(() =>
          this.authService.refreshToken().pipe(
            map((response: AuthResponse) => AuthActions.refreshTokenSuccess({ response })),
            catchError((error) => of(AuthActions.refreshTokenFailure({ error })))
          )
        )
      )
    );
  }
}
