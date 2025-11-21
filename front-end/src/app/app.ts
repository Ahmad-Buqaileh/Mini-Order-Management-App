import { Component, OnInit, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { Store } from '@ngrx/store';
import * as CartActions from './features/cart/store/cart.actions';
import { inject } from '@angular/core';
import * as AuthActions from './features/auth/store/auth.actions';
import { selectUserToken } from './features/auth/store/auth.selectors';

@Component({
  standalone: true,
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.scss',
})
export class App implements OnInit {
  private store = inject(Store);
  $userToken = this.store.select(selectUserToken);
  ngOnInit(): void {
    this.store.dispatch(AuthActions.refreshToken());
  }
  protected readonly title = signal('front-end');
}
