import { createAction, props } from '@ngrx/store';
import { OrderResponse } from '../services/order.service';

export const loadOrders = createAction('[Order] Load Orders', props<{ userId: string }>());
export const loadOrdersSuccess = createAction(
  '[Order] Load Orders Success',
  props<{ orders: OrderResponse[] }>()
);
export const loadOrderFailure = createAction(
  '[Order] Load Orders Failure',
  props<{ error: any }>()
);

export const createOrder = createAction('[Order] Create Order', props<{ userId: string }>());
export const createOrderSuccess = createAction(
  '[Order] Create Order Success',
  props<{ order: OrderResponse }>()
);
export const createOrderFailure = createAction(
  '[Order] Create Order Failure',
  props<{ error: any }>()
);

export const loadOrderItems = createAction(
  '[Order] Load Order Items',
  props<{ orderId: string }>()
);
export const loadOrderItemsSuccess = createAction(
  '[Order] Load Order Items Success',
  props<{ items: any[] }>()
);
export const loadOrderItemsFailure = createAction(
  '[Order] Load Order Items Failure',
  props<{ error: any }>()
);