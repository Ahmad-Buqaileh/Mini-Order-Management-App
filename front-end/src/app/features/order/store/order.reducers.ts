import { createReducer, on } from '@ngrx/store';
import {
  loadOrderFailure,
  loadOrders,
  loadOrdersSuccess,
  createOrderFailure,
  createOrder,
  createOrderSuccess,
  loadOrderItems,
  loadOrderItemsFailure,
  loadOrderItemsSuccess,
} from './order.actions';

export interface OrderState {
  orders: any[];
  orderItems: any[]; 
  loading: boolean;
  error: any;
}

export const initialState: OrderState = {
  orders: [],
  orderItems: [],
  loading: false,
  error: null,
};

export const orderReducer = createReducer(
  initialState,
  on(loadOrders, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loadOrdersSuccess, (state, { orders }) => ({
    ...state,
    orders,
    loading: false,
    error: null,
  })),
  on(loadOrderFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error,
  })),
  on(createOrder, (state) => ({
    ...state,
    loading: false,
    error: null,
  })),
  on(createOrderSuccess, (state, { order }) => ({
    ...state,
    orders: [...state.orders, order],
    error: null,
  })),
  on(createOrderFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error,
  })),
  on(loadOrderItems, (state) => ({
    ...state,
    loading: true,
    error: null,
  })),
  on(loadOrderItemsSuccess, (state, { items }) => ({
    ...state,
    orderItems: items,
    loading: false,
    error: null,
  })),
  on(loadOrderItemsFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error,
  })) 
);
