import { NgClass } from '@angular/common';
import { Component, inject, signal, DestroyRef } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Store } from '@ngrx/store';
import * as AuthActions from '../../store/auth.actions';
import { selectUserToken } from '../../store/auth.selectors';
import { Router } from '@angular/router';
import { filter } from 'rxjs';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  selector: 'app-auth-page',
  imports: [NgClass, FormsModule],
  templateUrl: './auth.page.html',
  styleUrl: './auth.page.scss',
})
export class AuthPage {
  isSignIn = signal(true);
  private store = inject(Store);
  private router = inject(Router);

  constructor() {
    this.store
      .select(selectUserToken)
      .pipe(
        filter((token) => !!token),
        takeUntilDestroyed(inject(DestroyRef))
      )
      .subscribe(() => {
        this.router.navigate(['/']);
      });
  }

  setIsSignIn(value: boolean) {
    this.isSignIn.set(value);
  }

  handleSubmit(formData: any) {
    const { name, email, password, confirmPassword } = formData.value;
    const trimmedName = name?.trim() || '';
    const trimmedEmail = email?.trim() || '';
    const trimmedPassword = password?.trim() || '';
    const trimmedConfirmPassword = confirmPassword?.trim() || '';
    if (!this.isSignIn() && trimmedPassword !== trimmedConfirmPassword) {
      alert('Password does not match');
      return;
    }
    if (this.isSignIn()) {
      this.store.dispatch(
        AuthActions.loginUser({
          credentials: { email: trimmedEmail, password: trimmedPassword },
        })
      );
    } else {
      this.store.dispatch(
        AuthActions.registerUser({
          credentials: { name: trimmedName, email: trimmedEmail, password: trimmedPassword },
        })
      );
    }
  }
}
