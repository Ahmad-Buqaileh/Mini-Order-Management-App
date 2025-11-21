import { Component, DestroyRef, inject } from '@angular/core';
import { RouterLink } from '@angular/router';
import { LucideAngularModule } from 'lucide-angular';
import { Observable } from 'rxjs';
import { AsyncPipe } from '@angular/common';
import { Store } from '@ngrx/store';
import * as AuthActions from '../../features/auth/store/auth.actions';
import { selectUserToken } from '../../features/auth/store/auth.selectors';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header-component',
  standalone: true,
  imports: [RouterLink, LucideAngularModule, AsyncPipe],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss',
})
export class HeaderComponent {
  private store = inject(Store);
  private router = inject(Router);
  userToken$!: Observable<string | null>;

  constructor() {
    this.userToken$ = this.store.select(selectUserToken);
  }

  logout() {
    this.store.dispatch(AuthActions.logoutUser());
    setTimeout(() => {
      this.router.navigate(['/auth']);
    }, 1000);
  }
}
