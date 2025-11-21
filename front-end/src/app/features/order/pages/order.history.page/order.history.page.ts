import { Component, OnInit, DestroyRef, inject } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { OrderCardComponent } from '../../components/order.card.component/order.card.component';
import { Store } from '@ngrx/store';
import { selectOrderState } from '../../store/order.selectors';
import { Observable } from 'rxjs';
import { OrderState } from '../../store/order.reducers';
import { AsyncPipe } from '@angular/common';
import * as OrderActions from '../../store/order.actions';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { Router } from '@angular/router';
import { selectUserToken } from '../../../auth/store/auth.selectors';

@Component({
  selector: 'app-order.history.page',
  imports: [HeaderComponent, OrderCardComponent, AsyncPipe],
  templateUrl: './order.history.page.html',
  styleUrl: './order.history.page.scss',
})
export class OrderHistoryPage implements OnInit {
  orders$!: Observable<OrderState>;
  userToken$: Observable<string>;
  userToken!: string;
  private store = inject(Store);
  private router = inject(Router);
  private destroyRef = inject(DestroyRef);

  constructor() {
    this.userToken$ = this.store.select(selectUserToken);
    this.userToken$.pipe(takeUntilDestroyed(this.destroyRef)).subscribe((token) => {
      if (!token) {
        this.router.navigate(['/auth']);
      }else {
        this.userToken = token;
      }
    });
  }

  ngOnInit(): void {
    this.store.dispatch(
      OrderActions.loadOrders({
        userToken: this.userToken,
      })
    );
    this.orders$ = this.store.select(selectOrderState);
  }
}
