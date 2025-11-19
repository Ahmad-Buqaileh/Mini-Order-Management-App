import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../../../../components/header.component/header.component';
import { OrderItemCardComponent } from '../../components/order.item.card.component/order.item.card.component';
import { CommonModule, AsyncPipe } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { map, Observable } from 'rxjs';
import * as OrderActions from '../../store/order.actions';
import { Store } from '@ngrx/store';
import { selectAllOrderItems } from '../../store/order.selectors';
import { OrderItemsResponse } from '../../services/order.service';

@Component({
  selector: 'app-order.info.page',
  imports: [OrderItemCardComponent, HeaderComponent, CommonModule, AsyncPipe],
  templateUrl: './order.info.page.html',
  styleUrl: './order.info.page.scss',
})
export class OrderInfoPage implements OnInit {
  orderId: string | null = null;
  orderItems$!: Observable<OrderItemsResponse[]>;
  totalPrice$!: Observable<number>;

  constructor(private route: ActivatedRoute, private store: Store) {
    this.totalPrice$ = this.store
      .select(selectAllOrderItems)
      .pipe(map((items) => items.reduce((acc, item) => acc + Number(item.subtotal), 0)));
  }

  ngOnInit(): void {
    this.orderId = this.route.snapshot.paramMap.get('orderId');
    if (this.orderId) {
      this.store.dispatch(OrderActions.loadOrderItems({ orderId: this.orderId }));
      this.orderItems$ = this.store.select(selectAllOrderItems);
    }
  }
}
