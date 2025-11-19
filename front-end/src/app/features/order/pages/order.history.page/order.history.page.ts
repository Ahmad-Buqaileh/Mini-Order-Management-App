import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { OrderCardComponent } from '../../components/order.card.component/order.card.component';
import { Store } from '@ngrx/store';
import { selectOrderState } from '../../store/order.selectors';
import { Observable } from 'rxjs';
import { OrderState } from '../../store/order.reducers';
import { AsyncPipe } from '@angular/common';
import * as OrderActions from '../../store/order.actions';

@Component({
  selector: 'app-order.history.page',
  imports: [HeaderComponent, OrderCardComponent, AsyncPipe],
  templateUrl: './order.history.page.html',
  styleUrl: './order.history.page.scss',
})
export class OrderHistoryPage implements OnInit {
  orders$!: Observable<OrderState>;
  private userId = '019a9609-46d4-7086-9ae9-70c535157d96';
  constructor(private store: Store) {}

  ngOnInit(): void {
    this.store.dispatch(
      OrderActions.loadOrders({
        userId: this.userId,
      })
    );
    this.orders$ = this.store.select(selectOrderState);
  }
}
