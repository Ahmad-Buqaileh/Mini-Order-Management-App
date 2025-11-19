import { createFeatureSelector, createSelector } from '@ngrx/store';
import { OrderState } from './order.reducers';

export const selectOrderState = createFeatureSelector<OrderState>('orders');

export const selectAllOrders = createSelector(selectOrderState, s => s.orders);
export const selectOrdersLoading = createSelector(selectOrderState, s => s.loading);
export const selectOrdersError = createSelector(selectOrderState, s => s.error);

export const selectCreateOrderLoading = createSelector(selectOrderState, s => s.loading);
export const selectCreateOrderError = createSelector(selectOrderState, s => s.error);

export const selectAllOrderItems = createSelector(selectOrderState, s => s.orderItems);
export const selectOrderItemsLoading = createSelector(selectOrderState, s => s.loading);
export const selectOrderItemsError = createSelector(selectOrderState, s => s.error);
