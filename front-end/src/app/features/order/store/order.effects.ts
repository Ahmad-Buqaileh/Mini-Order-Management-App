import { Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import * as OrderActions from '../store/order.actions';
import { OrderService } from '../services/order.service';
import { catchError, map, mergeMap, of } from 'rxjs';

@Injectable()
export class OrderEffects {
  loadOrders$: any;
  createOrder$: any;
  loadOrderItems$: any;

  constructor(private actions$: Actions, private orderService: OrderService) {
    this.loadOrders$ = createEffect(() =>
      this.actions$.pipe(
        ofType(OrderActions.loadOrders),
        mergeMap(({ userToken }) =>
          this.orderService.getOrderHistory(userToken).pipe(
            map((orders: any) => OrderActions.loadOrdersSuccess({ orders })),
            catchError((err) => of(OrderActions.loadOrderFailure({ error: err.message })))
          )
        )
      )
    );
    this.createOrder$ = createEffect(() =>
      this.actions$.pipe(
        ofType(OrderActions.createOrder),
        mergeMap(({ userToken }) =>
          this.orderService.createOrder(userToken).pipe(
            map((order) => OrderActions.createOrderSuccess({ order })),
            catchError((err) => of(OrderActions.createOrderFailure({ error: err.message })))
          )
        )
      )
    );
    this.loadOrderItems$ = createEffect(() =>
      this.actions$.pipe(
        ofType(OrderActions.loadOrderItems),
        mergeMap(({ orderId }) =>
          this.orderService.getOrderItems(orderId).pipe(
            map((items: any) => OrderActions.loadOrderItemsSuccess({ items })),
            catchError((err) => of(OrderActions.loadOrderItemsFailure({ error: err.message })))
          )
        )
      )
    );
  }
}
