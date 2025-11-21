import { Component, OnInit, signal, DestroyRef } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Store } from '@ngrx/store';
import * as CartActions from './features/cart/store/cart.actions';
import { inject } from '@angular/core';
import * as AuthActions from './features/auth/store/auth.actions';
import { selectUserToken } from './features/auth/store/auth.selectors';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  standalone: true,
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.scss',
})
export class App implements OnInit {
  private store = inject(Store);
  private destroyRef = inject(DestroyRef);
  userToken$ = this.store.select(selectUserToken);
  userToken!: string;
  ngOnInit(): void {
    this.store.dispatch(AuthActions.refreshToken());
    this.userToken$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((token) => {
      if (token) {
        this.userToken = token;
        this.store.dispatch(CartActions.createUserCart({ userToken: this.userToken }));
      }
    });
  }
  protected readonly title = signal('front-end');
}
